<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil semua project milik client untuk statistik
        $allProjects = $user->projects()->get();
        $projectIds = $allProjects->pluck('id');

        // Pagination untuk tampilan list
        $projects = $user->projects()
            ->with([
                'progressPhotos',
                'dailyReports',
                'invoices',
                'documents',
            ])
            ->latest()
            ->paginate(5);

        // Statistik Dashboard Client
        $stats = [
            'total_projects' => $allProjects->count(),

            'active_projects' => $allProjects
                ->where('status', 'in_progress')
                ->count(),

            'completed_projects' => $allProjects
                ->where('status', 'completed')
                ->count(),

            'pending_invoices' => Invoice::whereIn('project_id', $projectIds)
                ->where('status', 'sent')
                ->count(),
        ];

        return view('client.dashboard', compact(
            'projects',
            'stats'
        ));
    }
}
