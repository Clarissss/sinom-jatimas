<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $projectIds = auth()->user()->projects()->pluck('id');
        $projects = auth()->user()->projects;

        // Ambil hanya dari tabel documents milik user
        $query = DB::table('documents')
            ->join('projects', 'documents.project_id', '=', 'projects.id')
            ->whereIn('documents.project_id', $projectIds)
            ->select(
                'documents.id',
                'documents.file_name',
                'documents.project_id',
                'documents.type',
                'documents.created_at',
                'projects.name as project_name',
                DB::raw("'document' as source")
            );

        $collection = collect($query->get())->map(function($item) {
            $item->extra_path = null;
            return (array) $item;
        });

        // --- PROSEDUR FILTER DATA ---
        if ($request->filled('project_id')) {
            $collection = $collection->where('project_id', $request->project_id);
        }

        if ($request->filled('date')) {
            $searchDate = date('Y-m-d', strtotime($request->date));
            $collection = $collection->filter(function ($item) use ($searchDate) {
                return date('Y-m-d', strtotime($item['created_at'])) === $searchDate;
            });
        }

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $collection = $collection->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['file_name']), $search) ||
                       str_contains(strtolower($item['project_name']), $search);
            });
        }

        // Simpan data sebelum filter tipe kategori untuk kalkulasi counter card
        $allFilesBeforeTypeFilter = clone $collection;

        if ($request->filled('type')) {
            $collection = $collection->where('type', $request->type);
        }

        // Ambil hasil akhir nilai array collection
        $results = $collection->values();

        // Konfigurasi Card Kategori
        $categories = [
            'contract' => [
                'label' => 'Kontrak Kerja',
                'icon' => 'fa-file-contract',
                'color' => 'bg-orange-500',
                'count' => $allFilesBeforeTypeFilter->where('type', 'contract')->count()
            ],
            'field_map' => [
                'label' => 'Peta Lapangan',
                'icon' => 'fa-map',
                'color' => 'bg-amber-500',
                'count' => $allFilesBeforeTypeFilter->where('type', 'field_map')->count()
            ],
            'technical_drawing' => [
                'label' => 'Gambar Teknis',
                'icon' => 'fa-ruler-combined',
                'color' => 'bg-blue-500',
                'count' => $allFilesBeforeTypeFilter->where('type', 'technical_drawing')->count()
            ],
            'bast' => [
                'label' => 'BAST',
                'icon' => 'fa-clipboard-check',
                'color' => 'bg-emerald-500',
                'count' => $allFilesBeforeTypeFilter->where('type', 'bast')->count()
            ],
            'material_report' => [
                'label' => 'Laporan Material',
                'icon' => 'fa-boxes-stacked',
                'color' => 'bg-purple-500',
                'count' => $allFilesBeforeTypeFilter->where('type', 'material_report')->count()
            ],
            'other' => [
                'label' => 'Lainnya',
                'icon' => 'fa-file-lines',
                'color' => 'bg-gray-500',
                'count' => $allFilesBeforeTypeFilter->where('type', 'other')->count()
            ],
        ];

        return view('client.documents.index', compact('results', 'categories', 'projects'));
    }

    public function download(Request $request, $project, $document)
    {
        $doc = DB::table('documents')->where('id', $document)->first();
        if (!$doc || !Storage::exists($doc->file_path)) abort(404);

        return Storage::download($doc->file_path, $doc->file_name);
    }
}
