<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('client')->latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
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
        $project->load(['client', 'progressPhotos.uploader', 'dailyReports.creator', 'documents', 'invoices', 'chatMessages.sender']);
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $clients = User::where('role', 'client')->where('is_active', true)->get();
        return view('admin.projects.edit', compact('project', 'clients'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
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
}
