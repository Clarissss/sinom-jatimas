<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
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
        ->select('documents.id', 'documents.file_name', 'documents.project_id', 'documents.type', 'documents.created_at', 
                'projects.name as project_name', 'users.name as client_name', 'projects.client_id', DB::raw("'document' as source"));

    $chats = DB::table('chat_messages')
        ->join('projects', 'chat_messages.project_id', '=', 'projects.id')
        ->join('users', 'projects.client_id', '=', 'users.id')
        ->whereNotNull('chat_messages.file_path')
        ->select('chat_messages.id', 'chat_messages.file_name', 'chat_messages.project_id', DB::raw("'chat_file' as type"), 'chat_messages.created_at', 
                'projects.name as project_name', 'users.name as client_name', 'projects.client_id', DB::raw("'chat' as source"));

    $reports = DB::table('daily_reports')
        ->join('projects', 'daily_reports.project_id', '=', 'projects.id')
        ->join('users', 'projects.client_id', '=', 'users.id')
        ->whereNotNull('daily_reports.photo')
        ->select('daily_reports.id', DB::raw("daily_reports.photo as file_name"), 'daily_reports.project_id', DB::raw("'daily_report' as type"), 'daily_reports.created_at', 
                'projects.name as project_name', 'users.name as client_name', 'projects.client_id', DB::raw("'report' as source"));

    $combinedQuery = $docs->union($chats)->union($reports);

    // 2. Query Dasar untuk filter 
    $baseQuery = DB::table(DB::raw("({$combinedQuery->toSql()}) as combined"))
        ->mergeBindings($combinedQuery);

    // Filter ID Client (Bukan Nama lagi)
    if ($request->filled('client_id')) {
        $baseQuery->where('client_id', $request->client_id);
    }
    // Filter ID Project (Bukan Nama lagi)
    if ($request->filled('project_id')) {
        $baseQuery->where('project_id', $request->project_id);
    }
    // Filter Tanggal
    if ($request->filled('date')) {
        $baseQuery->whereDate('created_at', $request->date);
    }

    $allFilesBeforeTypeFilter = $baseQuery->get();

    // 3. Query Hasil Akhir (Filter Kategori) 
    $resultsQuery = clone $baseQuery;
    if ($request->filled('type')) {
        $resultsQuery->where('type', $request->type);
    }

    $results = $resultsQuery->orderBy('created_at', 'desc')->get();

    // 4. Konfigurasi Card Kategori 
    $categories = [
        'daily_report' => ['label' => 'Laporan Harian', 'icon' => 'fa-calendar-check', 'color' => 'bg-emerald-600', 'count' => $allFilesBeforeTypeFilter->where('type', 'daily_report')->count()],
        'chat_file' => ['label' => 'File Chat', 'icon' => 'fa-comment-dots', 'color' => 'bg-blue-600', 'count' => $allFilesBeforeTypeFilter->where('type', 'chat_file')->count()],
        'contract' => ['label' => 'Kontrak Kerja', 'icon' => 'fa-file-contract', 'color' => 'bg-orange-500', 'count' => $allFilesBeforeTypeFilter->where('type', 'contract')->count()],
    ];

    return view('admin.documents.index', compact('results', 'categories', 'projects', 'clients'));
}
    public function download(Request $request, $id)
    {
        $source = $request->query('source');

        if ($source === 'report') {
            $report = DB::table('daily_reports')->where('id', $id)->first();
            // Asumsi file laporan harian disimpan di disk public/local
            if (!$report || !Storage::exists($report->photo)) abort(404);
            return Storage::download($report->photo);
        }

        if ($source === 'chat') {
            $chat = DB::table('chat_messages')->where('id', $id)->first();
            // Sesuai screenshot Anda, chat menggunakan disk private
            if (!$chat || !Storage::disk('private')->exists($chat->file_path)) abort(404);
            return Storage::disk('private')->download($chat->file_path, $chat->file_name);
        }

        $document = Document::findOrFail($id);
        if (!Storage::exists($document->file_path)) abort(404);
        return Storage::download($document->file_path, $document->file_name);
    }
}