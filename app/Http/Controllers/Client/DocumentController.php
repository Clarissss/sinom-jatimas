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

        // 1. Ambil Kategori Dokumen Utama
        $docs = DB::table('documents')
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

        // 2. Ambil berkas dari Invoice (Mengganti chat_file lama)
        $invoices = DB::table('chat_messages')
            ->join('projects', 'chat_messages.project_id', '=', 'projects.id')
            ->whereIn('chat_messages.project_id', $projectIds)
            ->whereNotNull('chat_messages.file_path')
            ->select(
                'chat_messages.id',
                'chat_messages.file_name',
                'chat_messages.project_id',
                DB::raw("'invoice' as type"), // Mengubah jenis kategori menjadi invoice
                'chat_messages.created_at',
                'projects.name as project_name',
                DB::raw("'chat' as source")
            );

        // 3. Ambil berkas dari Laporan Harian (Raw string koma)
        $reportsRaw = DB::table('daily_reports')
            ->join('projects', 'daily_reports.project_id', '=', 'projects.id')
            ->whereIn('daily_reports.project_id', $projectIds)
            ->whereNotNull('daily_reports.photo')
            ->select(
                'daily_reports.id',
                'daily_reports.photo as raw_photos',
                'daily_reports.project_id',
                DB::raw("'daily_report' as type"),
                'daily_reports.created_at',
                'projects.name as project_name',
                DB::raw("'report' as source")
            )
            ->get();

        // 4. Urai multiple foto laporan harian menjadi baris mandiri
        $parsedReports = [];
        foreach ($reportsRaw as $report) {
            $photoArray = explode(',', $report->raw_photos);
            foreach ($photoArray as $photoPath) {
                if (!empty(trim($photoPath))) {
                    $parsedReports[] = [
                        'id' => $report->id,
                        'file_name' => basename(trim($photoPath)),
                        'project_id' => $report->project_id,
                        'type' => $report->type,
                        'created_at' => $report->created_at,
                        'project_name' => $report->project_name,
                        'source' => $report->source,
                        'extra_path' => trim($photoPath) // Path spesifik untuk download
                    ];
                }
            }
        }

        // Ambil hasil query dokumen dan invoice
        $combinedDocsAndInvoices = $docs->union($invoices)->get();

        // Gabungkan seluruh data ke dalam format Collection tunggal
        $collection = collect($combinedDocsAndInvoices)->map(function($item) {
            $item->extra_path = null;
            return (array) $item;
        })->merge($parsedReports);

        // Urutkan data berdasarkan tanggal pembuatan terbaru
        $collection = $collection->sortByDesc('created_at');

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

        // 5. Konfigurasi Card Kategori (Menyesuaikan Invoice Tagihan)
        $categories = [
            'daily_report' => [
                'label' => 'Laporan Harian',
                'icon' => 'fa-calendar-check',
                'color' => 'bg-emerald-600',
                'count' => $allFilesBeforeTypeFilter->where('type', 'daily_report')->count()
            ],
            'invoice' => [
                'label' => 'Invoice Tagihan',
                'icon' => 'fa-file-invoice-dollar',
                'color' => 'bg-blue-600',
                'count' => $allFilesBeforeTypeFilter->where('type', 'invoice')->count()
            ],
            'contract' => [
                'label' => 'Kontrak Kerja',
                'icon' => 'fa-file-contract',
                'color' => 'bg-orange-500',
                'count' => $allFilesBeforeTypeFilter->where('type', 'contract')->count()
            ],
        ];

        return view('client.documents.index', compact('results', 'categories', 'projects'));
    }

    public function download(Request $request, $project, $document)
    {
        $source = $request->query('source');
        $extraPath = $request->query('path'); 

        if ($source === 'report') {
            if ($extraPath && Storage::disk('public')->exists($extraPath)) {
                return Storage::disk('public')->download($extraPath);
            }

            $report = DB::table('daily_reports')->where('id', $document)->first();
            if (!$report) abort(404);

            $photos = explode(',', $report->photo);
            $firstPhoto = trim($photos[0]);
            if (!Storage::disk('public')->exists($firstPhoto)) abort(404);

            return Storage::disk('public')->download($firstPhoto);
        }

        if ($source === 'chat') {
            $chat = DB::table('chat_messages')->where('id', $document)->first();
            if (!$chat || !Storage::disk('private')->exists($chat->file_path)) abort(404);

            return Storage::disk('private')->download($chat->file_path, $chat->file_name);
        }

        $doc = DB::table('documents')->where('id', $document)->first();
        if (!$doc || !Storage::exists($doc->file_path)) abort(404);

        return Storage::download($doc->file_path, $doc->file_name);
    }
}