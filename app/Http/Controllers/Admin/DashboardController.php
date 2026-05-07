<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama
        $stats = [
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'in_progress')->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            'total_clients' => User::where('role', 'client')->count(),
            'pending_invoices' => Invoice::where('status', 'sent')->count(),
            'overdue_invoices' => Invoice::where('status', 'overdue')->count(),
            'total_revenue' => Invoice::where('status', 'paid')
                ->whereHas('project', function($query) {
                    $query->where('status', 'completed');
                })->sum('amount'),
        ];

        // 2. Data untuk Peta Nasional (Hanya yang memiliki koordinat)
        $projects_for_map = Project::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'name', 'latitude', 'longitude', 'status', 'progress_percentage']);

        // 3. Data Grafik Arus Kas (6 Bulan Terakhir)
        $revenue_data = Invoice::where('status', 'paid')
            ->whereHas('project', function($query) { $query->where('status', 'completed'); })
            ->where('paid_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(paid_at, "%M") as month, SUM(amount) as total, MIN(paid_at) as sort_date')
            ->groupBy('month')
            ->orderBy('sort_date')
            ->get();

        // 4. Distribusi Proyek untuk Doughnut Chart
        $project_distribution = [
            Project::where('status', 'pending')->count(),
            Project::where('status', 'in_progress')->count(),
            Project::where('status', 'completed')->count(),
        ];

        // 5. Data Tabel Terbaru
        $recent_projects = Project::with('client')->latest()->limit(5)->get();
        $recent_invoices = Invoice::with(['project.client'])->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'projects_for_map', 'recent_projects', 
            'recent_invoices', 'revenue_data', 'project_distribution'
        ));
    }
}