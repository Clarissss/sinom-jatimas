<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DailyReportController extends Controller
{
    public function index(Request $request)
    {
        $projectIds = auth()->user()->projects()->pluck('id');

        $query = DailyReport::with([
                'project',
                'creator',
                'client'
            ])
            ->whereIn('project_id', $projectIds)
            ->latest();

        // Jika filter project dipilih, tambahkan kondisi where untuk memfilter berdasarkan project_id
        if ($request->filled('project_id')) {

            $query->where('project_id', $request->project_id);
        }

        // Jika filter date dipilih, tambahkan kondisi where untuk memfilter berdasarkan report_date
        if ($request->filled('date')) {

            $query->whereDate('report_date', $request->date);
        }

        $reports = $query
            ->paginate(15)
            ->withQueryString();

        $projects = auth()->user()
            ->projects()
            ->orderBy('name')
            ->get();

        return view('client.daily-reports.index', compact(
            'reports',
            'projects'
        ));
    }

    public function show($project)
    {
        $dailyReport = DailyReport::with([
            'project',
            'creator',
            'client'
        ])->findOrFail($project);

        return view('client.daily-reports.show', compact(
            'dailyReport'
        ));
    }

    public function downloadPhoto(DailyReport $dailyReport, $photo)
    {
        $photoPath = base64_decode($photo, true);

        if ($photoPath === false || !Storage::disk('public')->exists($photoPath)) {
            abort(404);
        }

        return Storage::disk('public')->download($photoPath);
    }
}