<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectUpdateRequest;
use App\Http\Requests\UpdateProjectUpdateRequest;
use App\Services\ProjectUpdateService;
use Illuminate\Http\JsonResponse;

class ProjectUpdateController extends Controller
{

    protected ProjectUpdateService $projectUpdateService;

    public function __construct(ProjectUpdateService $projectUpdateService)
    {
        $this->projectUpdateService = $projectUpdateService;
    }

    public function store(StoreProjectUpdateRequest $request): JsonResponse
    {

        $update = $this->projectUpdateService
            ->createUpdate($request->validated());

        if($update){
            return response()->json([
                'success'=>true,
                'message'=>'Project update added.',
                'data'=>$update
            ]);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Update failed.'
        ],500);
    }

    public function update(UpdateProjectUpdateRequest $request,$id): JsonResponse
    {

        $update = $this->projectUpdateService
            ->updateUpdate($id,$request->validated());

        if($update){
            return response()->json([
                'success'=>true,
                'message'=>'Update modified.',
                'data'=>$update
            ]);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Update failed.'
        ],500);
    }

    public function destroy($id): JsonResponse
    {

        $deleted = $this->projectUpdateService
            ->deleteUpdate($id);

        if($deleted){
            return response()->json([
                'success'=>true,
                'message'=>'Update deleted.'
            ]);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Delete failed.'
        ],500);
    }

}