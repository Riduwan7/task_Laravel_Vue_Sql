<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        return view('admin.projects.list');
    }

    public function data(Request $request)
    {
        return $this->projectService->getDataTablesData();
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {

        $project = $this->projectService->createProject(
            $request->validated()
        );

        if($project){
            return response()->json([
                'success'=>true,
                'message'=>'Project created successfully.',
                'data'=>$project
            ]);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Project creation failed.'
        ],500);
    }

    public function edit(string $id): JsonResponse
    {

        $project = $this->projectService->getProjectById($id);

        if(!$project){
            return response()->json([
                'success'=>false,
                'message'=>'Project not found.'
            ],404);
        }

        return response()->json([
            'success'=>true,
            'data'=>$project
        ]);
    }

    public function update(UpdateProjectRequest $request,string $id): JsonResponse
    {

        $project = $this->projectService->updateProject(
            $id,
            $request->validated()
        );

        if($project){
            return response()->json([
                'success'=>true,
                'message'=>'Project updated successfully.',
                'data'=>$project
            ]);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Update failed.'
        ],500);
    }

    public function destroy(string $id): JsonResponse
    {

        $deleted = $this->projectService->deleteProject($id);

        if($deleted){
            return response()->json([
                'success'=>true,
                'message'=>'Project deleted successfully.'
            ]);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Delete failed.'
        ],500);
    }

}