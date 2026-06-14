<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::orderBy('name')->get();
        $clients = User::where('role', 'client')->orderBy('name')->get();

        $items = collect();

        // 1. Dokumen manual (tabel documents)
        $documents = \DB::table('documents')
            ->join('projects', 'documents.project_id', '=', 'projects.id')
            ->join('users', 'projects.client_id', '=', 'users.id')
            ->select(
                'documents.id as id',
                'documents.file_name as file_name',
                'documents.type as type',
                'documents.created_at as created_at',
                'projects.id as project_id',
                'projects.name as project_name',
                'users.id as client_id',
                'users.name as client_name'
            )
            ->get();

        foreach ($documents as $doc) {
            $items->push([
                'id' => $doc->id,
                'file_name' => $doc->file_name,
                'type' => $doc->type,
                'created_at' => $doc->created_at,
                'project_id' => $doc->project_id,
                'project_name' => $doc->project_name,
                'client_id' => $doc->client_id,
                'client_name' => $doc->client_name,
                'source' => 'document',
                'extra_path' => null,
            ]);
        }

        // 2. Invoice (file PDF)
        Invoice::with(['project.client'])->chunk(100, function ($invoices) use ($items) {
            foreach ($invoices as $invoice) {
                if (!$invoice->pdf_path) {
                    continue;
                }

                $items->push([
                    'id' => $invoice->id,
                    'file_name' => "Invoice_{$invoice->invoice_number}.pdf",
                    'type' => 'invoice',
                    'created_at' => $invoice->created_at,
                    'project_id' => $invoice->project_id,
                    'project_name' => $invoice->project?->name ?? '-',
                    'client_id' => $invoice->project?->client_id,
                    'client_name' => $invoice->project?->client?->name ?? '-',
                    'source' => 'invoice',
                    'extra_path' => null,
                ]);
            }
        });

        // 3. Laporan Harian (foto)
        DailyReport::with(['project', 'client'])->chunk(100, function ($reports) use ($items) {
            foreach ($reports as $report) {
                if (!$report->photo) {
                    continue;
                }

                $photos = array_filter(array_map('trim', explode(',', $report->photo)));
                foreach ($photos as $photo) {
                    $items->push([
                        'id' => $report->id,
                        'file_name' => basename($photo),
                        'type' => 'daily_report',
                        'created_at' => $report->created_at,
                        'project_id' => $report->project_id,
                        'project_name' => $report->project?->name ?? '-',
                        'client_id' => $report->client_id,
                        'client_name' => $report->client?->name ?? '-',
                        'source' => 'daily_report',
                        'extra_path' => $photo,
                    ]);
                }
            }
        });

        // Filter
        if ($request->filled('client_id')) {
            $items = $items->where('client_id', (int) $request->client_id);
        }

        if ($request->filled('project_id')) {
            $items = $items->where('project_id', (int) $request->project_id);
        }

        if ($request->filled('date')) {
            $searchDate = date('Y-m-d', strtotime($request->date));
            $items = $items->filter(function ($item) use ($searchDate) {
                return date('Y-m-d', strtotime($item['created_at'])) === $searchDate;
            });
        }

        $allFilesBeforeTypeFilter = $items;

        if ($request->filled('type')) {
            $items = $items->where('type', $request->type);
        }

        $results = $items->sortByDesc('created_at')->values();

        $categories = [
            'contract' => ['label' => 'Kontrak Kerja', 'icon' => 'fa-file-contract', 'color' => 'bg-orange-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'contract')->count()],
            'field_map' => ['label' => 'Peta Lapangan', 'icon' => 'fa-map', 'color' => 'bg-amber-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'field_map')->count()],
            'technical_drawing' => ['label' => 'Gambar Teknis', 'icon' => 'fa-ruler-combined', 'color' => 'bg-blue-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'technical_drawing')->count()],
            'bast' => ['label' => 'BAST', 'icon' => 'fa-clipboard-check', 'color' => 'bg-emerald-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'bast')->count()],
            'material_report' => ['label' => 'Laporan Material', 'icon' => 'fa-boxes-stacked', 'color' => 'bg-purple-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'material_report')->count()],
            'invoice' => ['label' => 'Invoice', 'icon' => 'fa-file-invoice-dollar', 'color' => 'bg-cyan-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'invoice')->count()],
            'daily_report' => ['label' => 'Laporan Harian', 'icon' => 'fa-images', 'color' => 'bg-pink-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'daily_report')->count()],
            'other' => ['label' => 'Lainnya', 'icon' => 'fa-file-lines', 'color' => 'bg-gray-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'other')->count()],
        ];

        return view('admin.documents.index', compact('results', 'categories', 'projects', 'clients'));
    }

    public function download(Request $request, $id)
    {
        $document = \App\Models\Document::findOrFail($id);
        if (!Storage::exists($document->file_path)) {
            abort(404);
        }

        return Storage::download($document->file_path, $document->file_name);
    }
}
