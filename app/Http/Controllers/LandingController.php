<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        return view('landing', array_merge($this->publicStats(), [
            'activePage' => 'home',
            'projects' => Project::with(['progressPhotos' => function ($query) {
                $query->whereNotNull('photo_path')->latest()->limit(1);
            }])->latest()->take(6)->get(),
            'partners' => Partner::where('is_active', true)->latest()->take(6)->get(),
        ]));
    }

    public function about(): View
    {
        return view('about', array_merge($this->publicStats(), [
            'activePage' => 'about',
        ]));
    }

    public function service(): View
    {
        return view('service', array_merge($this->publicStats(), [
            'activePage' => 'service',
            'services' => Service::where('is_active', true)->orderBy('name')->get(),
        ]));
    }

public function project()
{
    $projects = Project::with([
        'client',
        'progressPhotos'
    ])->latest()->get();

    $projectsForMap = Project::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get([
            'id',
            'name',
            'location',
            'latitude',
            'longitude',
            'status',
            'progress_percentage'
        ]);

    return view('project', compact(
        'projects',
        'projectsForMap'
    ));
}

public function contact()
{
    return view('contact', array_merge(
        $this->publicStats(),
        [
            'activePage' => 'contact'
        ]
    ));
}

    /**
     * @return array{
     *     companyProfile: ?CompanyProfile,
     *     yearsOfExperience: int,
     *     totalProjects: int,
     *     projectsOngoing: int,
     *     projectsCompleted: int
     * }
     */
    private function publicStats(): array
    {
        $companyProfile = CompanyProfile::first();
        $yearsOfExperience = max(1, (int) now()->year - 2014);
        $totalProjects = Project::count();
        $projectsOngoing = Project::whereIn('status', ['pending', 'in_progress'])->count();
        $projectsCompleted = Project::where('status', 'completed')->count();

        return compact(
            'companyProfile',
            'yearsOfExperience',
            'totalProjects',
            'projectsOngoing',
            'projectsCompleted'
        );
    }
}
