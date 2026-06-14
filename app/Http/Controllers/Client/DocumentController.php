<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $projectIds = auth()->user()->projects()->pluck('id');
        $projects = auth()->user()->projects;

        $items = collect();

        // 1. Dokumen manual (tabel documents)
        $documents = DB::table('documents')
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
            )
            ->get();

        foreach ($documents as $doc) {
            $items->push([
                'id' => $doc->id,
                'file_name' => $doc->file_name,
                'project_id' => $doc->project_id,
                'type' => $doc->type,
                'created_at' => $doc->created_at,
                'project_name' => $doc->project_name,
                'source' => 'document',
                'extra_path' => null,
            ]);
        }

        // 2. Invoice milik proyek klien
        Invoice::with('project')
            ->whereIn('project_id', $projectIds)
            ->chunk(100, function ($invoices) use ($items) {
                foreach ($invoices as $invoice) {
                    if (!$invoice->pdf_path) {
                        continue;
                    }

                    $items->push([
                        'id' => $invoice->id,
                        'file_name' => "Invoice_{$invoice->invoice_number}.pdf",
                        'project_id' => $invoice->project_id,
                        'type' => 'invoice',
                        'created_at' => $invoice->created_at,
                        'project_name' => $invoice->project?->name ?? '-',
                        'source' => 'invoice',
                        'extra_path' => null,
                    ]);
                }
            });

        // 3. Foto laporan harian milik proyek klien
        DailyReport::with('project')
            ->whereIn('project_id', $projectIds)
            ->chunk(100, function ($reports) use ($items) {
                foreach ($reports as $report) {
                    if (!$report->photo) {
                        continue;
                    }

                    $photos = array_filter(array_map('trim', explode(',', $report->photo)));
                    foreach ($photos as $photo) {
                        $items->push([
                            'id' => $report->id,
                            'file_name' => basename($photo),
                            'project_id' => $report->project_id,
                            'type' => 'daily_report',
                            'created_at' => $report->created_at,
                            'project_name' => $report->project?->name ?? '-',
                            'source' => 'daily_report',
                            'extra_path' => $photo,
                        ]);
                    }
                }
            });

        // --- PROSEDUR FILTER DATA ---
        if ($request->filled('project_id')) {
            $items = $items->where('project_id', (int) $request->project_id);
        }

        if ($request->filled('date')) {
            $searchDate = date('Y-m-d', strtotime($request->date));
            $items = $items->filter(function ($item) use ($searchDate) {
                return date('Y-m-d', strtotime($item['created_at'])) === $searchDate;
            });
        }

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $items = $items->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['file_name']), $search) ||
                       str_contains(strtolower($item['project_name']), $search);
            });
        }

        $allFilesBeforeTypeFilter = $items;

        if ($request->filled('type')) {
            $items = $items->where('type', $request->type);
        }

        $results = $items->values();

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
            'invoice' => [
                'label' => 'Invoice',
                'icon' => 'fa-file-invoice-dollar',
                'color' => 'bg-cyan-500',
                'count' => $allFilesBeforeTypeFilter->where('type', 'invoice')->count()
            ],
            'daily_report' => [
                'label' => 'Laporan Harian',
                'icon' => 'fa-images',
                'color' => 'bg-pink-500',
                'count' => $allFilesBeforeTypeFilter->where('type', 'daily_report')->count()
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
