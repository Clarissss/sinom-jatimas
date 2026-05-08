<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil hanya project milik client login
        $projects = $user->projects()
            ->with([
                'progressPhotos',
                'dailyReports',
                'invoices',
                'documents',
            ])
            ->latest()
            ->get();

        // Statistik Dashboard Client
        $stats = [
            'total_projects' => $projects->count(),

            'active_projects' => $projects
                ->where('status', 'in_progress')
                ->count(),

            'completed_projects' => $projects
                ->where('status', 'completed')
                ->count(),

            'pending_invoices' => $projects
                ->pluck('invoices')
                ->flatten()
                ->where('status', 'sent')
                ->count(),
        ];

        return view('client.dashboard', compact(
            'projects',
            'stats'
        ));
    }
}