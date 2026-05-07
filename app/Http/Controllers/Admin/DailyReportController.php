<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DailyReportController extends Controller
{
    public function index(Request $request)
    {
        $query = DailyReport::with(['client', 'project', 'creator'])->latest();

        // Filter berdasarkan Klien
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter berdasarkan Proyek
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Filter berdasarkan Tanggal
        if ($request->filled('date')) {
            $query->whereDate('report_date', $request->date);
        }

        // withQueryString() digunakan agar saat pindah halaman (pagination), filternya tidak hilang
        $reports = $query->paginate(15)->withQueryString();

        // Mengambil data untuk mengisi dropdown filter
        $clients = User::where('name', '!=', 'Administrator')->orderBy('name')->get();
        $projects = Project::orderBy('name')->get();

        return view('admin.daily-reports.index', compact('reports', 'clients', 'projects'));
    }

    public function create()
    {

        $clients = User::where('name', '!=', 'Administrator')->orderBy('name')->get(); 
        
        $projects = Project::whereIn('status', ['in_progress', 'pending'])->get();
        
        return view('admin.daily-reports.create', compact('clients', 'projects'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:users,id'], 
            'project_id' => ['required', 'exists:projects,id'],
            'report_date' => ['required', 'date'],
            'activity_description' => ['required', 'string'],
            'weather_condition' => ['required', 'in:sunny,cloudy,rainy,storm'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data = $validated;
        
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('daily-reports', 'public');
        }

        DailyReport::create([
            ...$data,
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
        $clients = User::where('name', '!=', 'Administrator')->orderBy('name')->get(); 
        
        $projects = Project::whereIn('status', ['in_progress', 'pending'])->get();
        
        return view('admin.daily-reports.edit', compact('dailyReport', 'clients', 'projects'));
    }

    public function update(Request $request, DailyReport $dailyReport)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:users,id'], 
            'project_id' => ['required', 'exists:projects,id'],
            'report_date' => ['required', 'date'],
            'activity_description' => ['required', 'string'],
            'weather_condition' => ['required', 'in:sunny,cloudy,rainy,storm'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data = $validated;

        if ($request->hasFile('photo')) {
            if ($dailyReport->photo) {
                Storage::disk('public')->delete($dailyReport->photo);
            }
            $data['photo'] = $request->file('photo')->store('daily-reports', 'public');
        }

        $dailyReport->update($data);

        return redirect()->route('admin.daily-reports.index')->with('success', 'Laporan harian berhasil diperbarui.');
    }

    public function destroy(DailyReport $dailyReport)
    {
        if ($dailyReport->photo) {
            Storage::disk('public')->delete($dailyReport->photo);
        }
        
        $dailyReport->delete();
        
        return redirect()->route('admin.daily-reports.index')->with('success', 'Laporan harian berhasil dihapus.');
    }
}