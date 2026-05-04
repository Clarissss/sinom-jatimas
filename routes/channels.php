<?php

use App\Models\Project;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('project.{projectId}', function ($user, $projectId) {
    $project = Project::find($projectId);
    
    if (!$project) {
        return false;
    }
    
    // Admin can access all project channels
    if ($user->isAdmin()) {
        return true;
    }
    
    // Client can only access their own project channels
    if ($user->isClient() && $project->client_id === $user->id) {
        return true;
    }
    
    return false;
});
