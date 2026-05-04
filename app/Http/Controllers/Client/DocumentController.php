<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $projectIds = auth()->user()->projects()->pluck('id');
        
        $documents = Document::with('project')
            ->whereIn('project_id', $projectIds)
            ->latest()
            ->paginate(15);

        return view('client.documents.index', compact('documents'));
    }

    public function download(Project $project, Document $document)
    {
        $this->authorize('view', $project);

        if ($document->project_id !== $project->id) {
            abort(403);
        }

        if (!Storage::exists($document->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::download($document->file_path, $document->file_name);
    }
}
