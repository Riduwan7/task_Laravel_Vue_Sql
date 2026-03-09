<?php

namespace App\Http\Controllers\Client;

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
            ->getClientProjects(Auth::id());

        return view('client.projects.list', compact('projects'));
    }

    public function show($id)
    {

        $project = $this->projectService
            ->getProjectById($id);

        return view('client.projects.show', compact('project'));
    }

    public function data()
    {
        $projects = \App\Models\Project::with('developer')
            ->where('client_id', auth()->id())
            ->latest()
            ->get();

        return response()->json([
            'data' => $projects
        ]);
    }
}
