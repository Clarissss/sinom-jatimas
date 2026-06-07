<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data untuk dropdown filter 
        $projects = Project::all();
        $clients = User::where('role', 'client')->get();

        // Ambil hanya dari tabel documents
        $query = DB::table('documents')
            ->join('projects', 'documents.project_id', '=', 'projects.id')
            ->join('users', 'projects.client_id', '=', 'users.id')
            ->select(
                'documents.id', 
                'documents.file_name', 
                'documents.project_id', 
                'documents.type', 
                'documents.created_at', 
                'projects.name as project_name', 
                'users.name as client_name', 
                'projects.client_id', 
                DB::raw("'document' as source")
            );

        // Prosedur Filter Manual pada Laravel Collection
        $collection = collect($query->get())->map(function($item) {
            $item->extra_path = null;
            return (array) $item;
        });

        if ($request->filled('client_id')) {
            $collection = $collection->where('client_id', $request->client_id);
        }
        if ($request->filled('project_id')) {
            $collection = $collection->where('project_id', $request->project_id);
        }
        if ($request->filled('date')) {
            $searchDate = date('Y-m-d', strtotime($request->date));
            $collection = $collection->filter(function($item) use ($searchDate) {
                return date('Y-m-d', strtotime($item['created_at'])) === $searchDate;
            });
        }

        // Simpan salinan data sebelum filter kategori (untuk menghitung counter card)
        $allFilesBeforeTypeFilter = clone $collection;

        if ($request->filled('type')) {
            $collection = $collection->where('type', $request->type);
        }

        // Urutkan berdasarkan data terbaru
        $results = $collection->sortByDesc('created_at')->values();

        // Konfigurasi Card Kategori
        $categories = [
            'contract' => ['label' => 'Kontrak Kerja', 'icon' => 'fa-file-contract', 'color' => 'bg-orange-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'contract')->count()],
            'field_map' => ['label' => 'Peta Lapangan', 'icon' => 'fa-map', 'color' => 'bg-amber-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'field_map')->count()],
            'technical_drawing' => ['label' => 'Gambar Teknis', 'icon' => 'fa-ruler-combined', 'color' => 'bg-blue-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'technical_drawing')->count()],
            'bast' => ['label' => 'BAST', 'icon' => 'fa-clipboard-check', 'color' => 'bg-emerald-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'bast')->count()],
            'material_report' => ['label' => 'Laporan Material', 'icon' => 'fa-boxes-stacked', 'color' => 'bg-purple-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'material_report')->count()],
            'other' => ['label' => 'Lainnya', 'icon' => 'fa-file-lines', 'color' => 'bg-gray-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'other')->count()],
        ];

        return view('admin.documents.index', compact('results', 'categories', 'projects', 'clients'));
    }

    public function download(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        if (!Storage::exists($document->file_path)) abort(404);
        return Storage::download($document->file_path, $document->file_name);
    }
}
