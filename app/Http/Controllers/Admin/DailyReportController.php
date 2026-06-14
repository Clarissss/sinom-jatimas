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

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('date')) { 
            $query->whereDate('report_date', $request->date);
        }

        $reports = $query->paginate(15)->withQueryString();

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
            'photos' => ['nullable', 'array'], 
            'photos.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data = $validated;
        unset($data['photos']); 

        // Proses penyimpanan multiple foto
        if ($request->hasFile('photos')) {
            $uploadedPhotos = [];
            foreach ($request->file('photos') as $file) {
                $uploadedPhotos[] = $file->store('daily-reports', 'public');
            }
            // Gabungkan array file path menjadi string dipisahkan oleh koma ","
            $data['photo'] = implode(',', $uploadedPhotos);
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
        if ($dailyReport->is_accepted) {
            return redirect()->route('admin.daily-reports.index')->with('error', 'Laporan tidak dapat diubah karena telah diterima oleh klien.');
        }

        $clients = User::where('name', '!=', 'Administrator')->orderBy('name')->get(); 
        $projects = Project::whereIn('status', ['in_progress', 'pending'])->get();
        
        return view('admin.daily-reports.edit', compact('dailyReport', 'clients', 'projects'));
    }

    public function update(Request $request, DailyReport $dailyReport)
    {
        if ($dailyReport->is_accepted) {
            return redirect()->route('admin.daily-reports.index')->with('error', 'Laporan tidak dapat diperbarui karena telah diterima oleh klien.');
        }

        $validated = $request->validate([
            'client_id' => ['required', 'exists:users,id'], 
            'project_id' => ['required', 'exists:projects,id'],
            'report_date' => ['required', 'date'],
            'activity_description' => ['required', 'string'],
            'weather_condition' => ['required', 'in:sunny,cloudy,rainy,storm'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data = $validated;
        unset($data['photos']);

        if ($request->hasFile('photos')) {
            // Hapus semua berkas fisik foto lama sebelum menimpa dengan yang baru
            if ($dailyReport->photo) {
                $oldPhotos = explode(',', $dailyReport->photo);
                foreach ($oldPhotos as $oldPhoto) {
                    Storage::disk('public')->delete(trim($oldPhoto));
                }
            }

            $uploadedPhotos = [];
            foreach ($request->file('photos') as $file) {
                $uploadedPhotos[] = $file->store('daily-reports', 'public');
            }
            $data['photo'] = implode(',', $uploadedPhotos);
        }

        $dailyReport->update($data);

        return redirect()->route('admin.daily-reports.index')->with('success', 'Laporan harian berhasil diperbarui.');
    }

    public function destroy(DailyReport $dailyReport)
    {
        if ($dailyReport->is_accepted) {
            return redirect()->route('admin.daily-reports.index')->with('error', 'Laporan tidak dapat dihapus karena telah diterima oleh klien.');
        }

        
        if ($dailyReport->photo) {
            $photos = explode(',', $dailyReport->photo);
            foreach ($photos as $photo) {
                Storage::disk('public')->delete(trim($photo));
            }
        }
        
        $dailyReport->delete();
        
        return redirect()->route('admin.daily-reports.index')->with('success', 'Laporan harian berhasil dihapus.');
    }

    public function acceptReport(DailyReport $dailyReport)
    {
        if (auth()->id() !== $dailyReport->client_id) {
            abort(403, 'Unauthorized action.');
        }

        $dailyReport->update(['is_accepted' => true]);

        return back()->with('success', 'Laporan harian berhasil dikonfirmasi dan diterima.');
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