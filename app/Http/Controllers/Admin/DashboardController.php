<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'in_progress')->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            'total_clients' => User::where('role', 'client')->count(),
            'pending_invoices' => Invoice::where('status', 'draft')->count(),
            'overdue_invoices' => Invoice::where('status', 'overdue')->count(),
        ];

        $recent_projects = Project::with('client')
            ->latest()
            ->limit(5)
            ->get();

        $recent_invoices = Invoice::with(['project.client'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_projects', 'recent_invoices'));
    }
}
