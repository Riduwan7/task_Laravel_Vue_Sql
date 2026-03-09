<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {

        $projects = $this->projectService
            ->getDeveloperProjects(Auth::id());

        return view('developer.projects.list', compact('projects'));
    }

    public function show($id)
    {

        $project = $this->projectService
            ->getProjectById($id);

        return view('developer.projects.show', compact('project'));
    }

    public function data()
    {
        $projects = \App\Models\Project::with('client')
            ->where('developer_id', auth()->id())
            ->latest()
            ->get();

        return response()->json([
            'data' => $projects
        ]);
    }
}
