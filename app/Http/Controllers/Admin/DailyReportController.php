<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\Project;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function index()
    {
        $reports = DailyReport::with(['project', 'creator'])->latest()->paginate(15);
        return view('admin.daily-reports.index', compact('reports'));
    }

    public function create()
    {
        $projects = Project::where('status', 'in_progress')->get();
        return view('admin.daily-reports.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'report_date' => ['required', 'date'],
            'activity_description' => ['required', 'string'],
            'weather_condition' => ['required', 'in:sunny,cloudy,rainy,storm'],
        ]);

        DailyReport::create([
            ...$validated,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.daily-reports.index')->with('success', 'Laporan harian berhasil dibuat.');
    }

    public function show(DailyReport $dailyReport)
    {
        return view('admin.daily-reports.show', compact('dailyReport'));
    }

    public function edit(DailyReport $dailyReport)
    {
        $projects = Project::where('status', 'in_progress')->get();
        return view('admin.daily-reports.edit', compact('dailyReport', 'projects'));
    }

    public function update(Request $request, DailyReport $dailyReport)
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'report_date' => ['required', 'date'],
            'activity_description' => ['required', 'string'],
            'weather_condition' => ['required', 'in:sunny,cloudy,rainy,storm'],
        ]);

        $dailyReport->update($validated);

        return redirect()->route('admin.daily-reports.index')->with('success', 'Laporan harian berhasil diperbarui.');
    }

    public function destroy(DailyReport $dailyReport)
    {
        $dailyReport->delete();
        return redirect()->route('admin.daily-reports.index')->with('success', 'Laporan harian berhasil dihapus.');
    }
}
