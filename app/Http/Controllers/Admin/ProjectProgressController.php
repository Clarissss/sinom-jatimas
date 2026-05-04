<?php

namespace App\Http\Controllers\Admin;

use App\Events\ProgressUpdated;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectProgress;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectProgressController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:before,progress,after'],
            'photo' => ['required', 'image', 'max:5120'], // Max 5MB
            'description' => ['nullable', 'string'],
        ]);

        $path = $request->file('photo')->store('progress-photos', 'local');

        $progress = ProjectProgress::create([
            'project_id' => $project->id,
            'type' => $validated['type'],
            'photo_path' => $path,
            'description' => $validated['description'],
            'uploaded_by' => auth()->id(),
        ]);

        try {
            broadcast(new ProgressUpdated($project))->toOthers();
        } catch (\Exception $e) {
            // Broadcast server tidak tersedia, lanjutkan tanpa broadcast
        }

        return back()->with('success', 'Foto progres berhasil diupload.');
    }

    public function updateProgress(Request $request, Project $project, InvoiceService $invoiceService)
    {
        $validated = $request->validate([
            'progress_percentage' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $project->update(['progress_percentage' => $validated['progress_percentage']]);

        $invoiceService->checkAndNotifyTermin($project);

        try {
            broadcast(new ProgressUpdated($project))->toOthers();
        } catch (\Exception $e) {
            // Broadcast server tidak tersedia, lanjutkan tanpa broadcast
        }

        return back()->with('success', 'Progress proyek berhasil diperbarui.');
    }

    public function destroy(Project $project, ProjectProgress $progress)
    {
        Storage::delete($progress->photo_path);
        $progress->delete();

        return back()->with('success', 'Foto progres berhasil dihapus.');
    }
}
