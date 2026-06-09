<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->get();

        return view('frontend.project', compact('projects'));
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_active, 404);

        $relatedProjects = Project::query()
            ->where('is_active', true)
            ->whereKeyNot($project->id)
            ->orderBy('sort_order')
            ->latest('id')
            ->limit(4)
            ->get();

        return view('frontend.project-details', compact('project', 'relatedProjects'));
    }
}
