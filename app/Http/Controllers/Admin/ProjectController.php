<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // LOGIKA AJAX: Harus diletakkan paling atas agar langsung merespon request JavaScript
        if ($request->ajax() || $request->has('get_projects')) {
            $projects = Project::where('client_id', $request->client_id)
                ->orderBy('name')
                ->get(['id', 'name']);
            return response()->json($projects);
        }

        $query = Project::with('client');

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter Klien
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter Proyek Tertentu
        if ($request->filled('project_id')) {
            $query->where('id', $request->project_id);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->latest()->paginate(10)->withQueryString();
        $clients = User::where('role', 'client')->orderBy('name')->get();

        return view('admin.projects.index', compact('projects', 'clients'));
    }


    public function create()
    {
        $clients = User::where('role', 'client')->where('is_active', true)->get();
        return view('admin.projects.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'contract_value' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:pending,in_progress,completed,cancelled'],
            'progress_percentage' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dibuat.');
    }

    public function show(Project $project)
    {
        $project->load([
            'client', 
            'progressPhotos.uploader', 
            'dailyReports.creator', 
            'documents', 
            'invoices', 
            'chatMessages.sender'
        ]);
        
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $project->load('invoices');
        $clients = User::where('role', 'client')->get();
        return view('admin.projects.edit', compact('project', 'clients'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'contract_value' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:pending,in_progress,completed,cancelled'],
            'progress_percentage' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus.');
    }

    /**
     * Tampilkan halaman Live Chat Proyek — list semua project dengan akses cepat ke chat.
     */
    public function chats(Request $request)
    {
        $query = Project::with(['client', 'chatMessages' => function ($q) {
            $q->latest()->limit(1);
        }]);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $projects = $query->latest()->get();
        $clients = User::where('role', 'client')->orderBy('name')->get();

        return view('admin.project-chats.index', compact('projects', 'clients'));
    }
}