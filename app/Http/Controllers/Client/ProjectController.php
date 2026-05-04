<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project->load([
            'progressPhotos.uploader', 
            'dailyReports.creator', 
            'documents', 
            'invoices',
            'chatMessages.sender'
        ]);

        return view('client.projects.show', compact('project'));
    }
}
