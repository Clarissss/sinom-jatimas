<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function index()
    {
        $projectIds = auth()->user()->projects()->pluck('id');
        
        $reports = \App\Models\DailyReport::with('project')
            ->whereIn('project_id', $projectIds)
            ->latest()
            ->paginate(15);

        return view('client.daily-reports.index', compact('reports'));
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $reports = $project->dailyReports()
            ->with('creator')
            ->orderBy('report_date', 'desc')
            ->paginate(15);

        return view('client.daily-reports.show', compact('project', 'reports'));
    }
}
