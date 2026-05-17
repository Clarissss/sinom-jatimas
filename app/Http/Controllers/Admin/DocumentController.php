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

        // 1. Definisikan sumber data (Union) dengan Join 
        $docs = DB::table('documents')
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

        // Mengubah chat_file lama menjadi penampung Invoice Otomatis
        $invoices = DB::table('chat_messages')
            ->join('projects', 'chat_messages.project_id', '=', 'projects.id')
            ->join('users', 'projects.client_id', '=', 'users.id')
            ->whereNotNull('chat_messages.file_path')
            ->select(
                'chat_messages.id', 
                'chat_messages.file_name', 
                'chat_messages.project_id', 
                DB::raw("'invoice' as type"), // Mengubah jenis kategori menjadi invoice
                'chat_messages.created_at', 
                'projects.name as project_name', 
                'users.name as client_name', 
                'projects.client_id', 
                DB::raw("'chat' as source")
            );

        $reportsRaw = DB::table('daily_reports')
            ->join('projects', 'daily_reports.project_id', '=', 'projects.id')
            ->join('users', 'projects.client_id', '=', 'users.id')
            ->whereNotNull('daily_reports.photo')
            ->select(
                'daily_reports.id', 
                'daily_reports.photo as raw_photos', // Ambil string gabungan koma
                'daily_reports.project_id', 
                DB::raw("'daily_report' as type"), 
                'daily_reports.created_at', 
                'projects.name as project_name', 
                'users.name as client_name', 
                'projects.client_id', 
                DB::raw("'report' as source")
            )
            ->get();

        // Mengolah data multiple foto laporan harian agar terpecah menjadi baris mandiri
        $parsedReports = [];
        foreach ($reportsRaw as $report) {
            $photoArray = explode(',', $report->raw_photos);
            foreach ($photoArray as $index => $photoPath) {
                if (!empty(trim($photoPath))) {
                    $parsedReports[] = [
                        'id' => $report->id,
                        'file_name' => basename(trim($photoPath)), // Ambil nama file asli saja untuk keindahan tabel
                        'project_id' => $report->project_id,
                        'type' => $report->type,
                        'created_at' => $report->created_at,
                        'project_name' => $report->project_name,
                        'client_name' => $report->client_name,
                        'client_id' => $report->client_id,
                        'source' => $report->source,
                        'extra_path' => trim($photoPath) // Menyimpan path asli untuk kebutuhan download
                    ];
                }
            }
        }

        // Ambil data Query Builder Dokumen & Invoice
        $combinedDocsAndInvoices = $docs->union($invoices)->get();

        // Konversi ke Collection agar bisa digabung dengan array laporan harian yang sudah di-parsing
        $collection = collect($combinedDocsAndInvoices)->map(function($item) {
            $item->extra_path = null;
            return (array) $item;
        })->merge($parsedReports);

        // Prosedur Filter Manual pada Laravel Collection
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

        // 4. Konfigurasi Card Kategori (Menghapus File Chat & Mengganti menjadi Invoice)
        $categories = [
            'daily_report' => ['label' => 'Laporan Harian', 'icon' => 'fa-calendar-check', 'color' => 'bg-emerald-600', 'count' => $allFilesBeforeTypeFilter->where('type', 'daily_report')->count()],
            'invoice' => ['label' => 'Invoice Tagihan', 'icon' => 'fa-file-invoice-dollar', 'color' => 'bg-blue-600', 'count' => $allFilesBeforeTypeFilter->where('type', 'invoice')->count()],
            'contract' => ['label' => 'Kontrak Kerja', 'icon' => 'fa-file-contract', 'color' => 'bg-orange-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'contract')->count()],
        ];

        return view('admin.documents.index', compact('results', 'categories', 'projects', 'clients'));
    }

    public function download(Request $request, $id)
    {
        $source = $request->query('source');
        $extraPath = $request->query('path'); // Menangkap path foto spesifik yang dikirim oleh Blade

        if ($source === 'report') {
            if ($extraPath && Storage::disk('public')->exists($extraPath)) {
                return Storage::disk('public')->download($extraPath);
            }
            
            $report = DB::table('daily_reports')->where('id', $id)->first();
            if (!$report) abort(404);
            
            // Fallback: Ambil foto indeks pertama jika parameter path terlewat
            $photos = explode(',', $report->photo);
            $firstPhoto = trim($photos[0]);
            if (!Storage::disk('public')->exists($firstPhoto)) abort(404);
            return Storage::disk('public')->download($firstPhoto);
        }

        if ($source === 'chat') {
            $chat = DB::table('chat_messages')->where('id', $id)->first();
            if (!$chat || !Storage::disk('private')->exists($chat->file_path)) abort(404);
            return Storage::disk('private')->download($chat->file_path, $chat->file_name);
        }

        $document = Document::findOrFail($id);
        if (!Storage::exists($document->file_path)) abort(404);
        return Storage::download($document->file_path, $document->file_name);
    }
}