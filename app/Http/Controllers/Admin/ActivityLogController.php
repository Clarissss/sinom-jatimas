<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        $logs = $query->paginate(50)->withQueryString();
        
        // Statistics
        $stats = [
            'total_today' => ActivityLog::today()->count(),
            'total_login' => ActivityLog::where('action', 'login')->today()->count(),
            'total_created' => ActivityLog::where('action', 'created')->today()->count(),
            'total_updated' => ActivityLog::where('action', 'updated')->today()->count(),
        ];

        // Get unique users for filter
        $users = \App\Models\User::select('id', 'name')->orderBy('name')->get();

        // Get unique actions for filter
        $actions = ActivityLog::select('action')->distinct()->pluck('action');

        return view('admin.activity-logs.index', compact('logs', 'stats', 'users', 'actions'));
    }

    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user', 'subject');
        return view('admin.activity-logs.show', compact('activityLog'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();
        return back()->with('success', 'Log berhasil dihapus.');
    }
}
