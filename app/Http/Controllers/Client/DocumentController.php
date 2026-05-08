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

        // KATEGORI DOKUMEN
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

        // Ambil file dari chat messages yang terkait dengan project user dan memiliki file
        $chats = DB::table('chat_messages')
            ->join('projects', 'chat_messages.project_id', '=', 'projects.id')
            ->whereIn('chat_messages.project_id', $projectIds)
            ->whereNotNull('chat_messages.file_path')
            ->select(
                'chat_messages.id',
                'chat_messages.file_name',
                'chat_messages.project_id',
                DB::raw("'chat_file' as type"),
                'chat_messages.created_at',
                'projects.name as project_name',
                DB::raw("'chat' as source")
            );

        // Ambil file dari daily reports yang terkait dengan project user dan memiliki foto
        $reports = DB::table('daily_reports')
            ->join('projects', 'daily_reports.project_id', '=', 'projects.id')
            ->whereIn('daily_reports.project_id', $projectIds)
            ->whereNotNull('daily_reports.photo')
            ->select(
                'daily_reports.id',
                DB::raw("daily_reports.photo as file_name"),
                'daily_reports.project_id',
                DB::raw("'daily_report' as type"),
                'daily_reports.created_at',
                'projects.name as project_name',
                DB::raw("'report' as source")
            );

        // Gabungkan semua query menggunakan union dan urutkan berdasarkan tanggal terbaru
        $results = $docs
            ->union($chats)
            ->union($reports)
            ->orderByDesc('created_at')
            ->get();

        // Jika ada filter project_id, tampilkan hanya dokumen dari project tersebut
        if ($request->filled('project_id')) {

            $results = $results->where(
                'project_id',
                $request->project_id
            );
        }

        // Jika ada filter type, tampilkan hanya dokumen dengan tipe
        if ($request->filled('type')) {

            $results = $results->where(
                'type',
                $request->type
            );
        }

        // Jika ada filter tanggal, tampilkan hanya dokumen dari tanggal tersebut
        if ($request->filled('date')) {

            $results = $results->filter(function ($item) use ($request) {

                return \Carbon\Carbon::parse($item->created_at)
                    ->format('Y-m-d') == $request->date;
            });
        }

        // Jika ada query search, tampilkan hanya dokumen yang nama file atau nama project mengandung kata kunci
        if ($request->filled('search')) {

            $search = strtolower($request->search);

            $results = $results->filter(function ($item) use ($search) {

                return str_contains(
                    strtolower($item->file_name),
                    $search
                ) ||

                str_contains(
                    strtolower($item->project_name),
                    $search
                );
            });
        }

        // Hitung jumlah dokumen untuk setiap kategori
        $categories = [

            'daily_report' => [
                'label' => 'Laporan Harian',
                'icon' => 'fa-calendar-check',
                'color' => 'bg-emerald-600',
                'count' => $results->where('type', 'daily_report')->count()
            ],

            'chat_file' => [
                'label' => 'File Chat',
                'icon' => 'fa-comment-dots',
                'color' => 'bg-blue-600',
                'count' => $results->where('type', 'chat_file')->count()
            ],

            'contract' => [
                'label' => 'Kontrak Kerja',
                'icon' => 'fa-file-contract',
                'color' => 'bg-orange-500',
                'count' => $results->where('type', 'contract')->count()
            ],
        ];

        return view('client.documents.index', compact(
            'results',
            'categories',
            'projects'
        ));
    }

    public function download(Request $request, $project, $document)
    {
        $source = $request->query('source');


        // Jika source adalah report, cari file di tabel daily_reports berdasarkan id dan pastikan file ada di storage sebelum mendownload
        if ($source === 'report') {

            $report = DB::table('daily_reports')
                ->where('id', $document)
                ->first();

            if (!$report || !Storage::exists($report->photo)) {
                abort(404);
            }

            return Storage::download($report->photo);
        }

        // Jika source adalah chat, cari file di tabel chat_messages berdasarkan id dan pastikan file ada di storage sebelum mendownload
        if ($source === 'chat') {

            $chat = DB::table('chat_messages')
                ->where('id', $document)
                ->first();

            if (
                !$chat ||
                !Storage::disk('private')->exists($chat->file_path)
            ) {
                abort(404);
            }

            return Storage::disk('private')
                ->download($chat->file_path, $chat->file_name);
        }

        // Cari file di tabel documents berdasarkan id dan pastikan file ada di storage sebelum mendownload
        $doc = DB::table('documents')
            ->where('id', $document)
            ->first();

        if (!$doc || !Storage::exists($doc->file_path)) {
            abort(404);
        }

        return Storage::download(
            $doc->file_path,
            $doc->file_name
        );
    }
}