<?php

namespace App\Services;

use App\Models\ProjectUpdate;
use Illuminate\Support\Facades\Log;

class ProjectUpdateService
{

    public function getProjectUpdates(int $projectId)
    {
        return ProjectUpdate::with('attachments')
            ->where('project_id',$projectId)
            ->latest()
            ->get();
    }

    public function createUpdate(array $data)
    {
        try{

            return ProjectUpdate::create($data);

        }catch(\Exception $e){

            Log::error('Create Project Update Error: '.$e->getMessage());
            return null;

        }
    }

    public function updateUpdate(int $id,array $data)
    {
        try{

            $update = ProjectUpdate::findOrFail($id);

            $update->update($data);

            return $update;

        }catch(\Exception $e){

            Log::error('Update Project Update Error: '.$e->getMessage());
            return null;

        }
    }

    public function deleteUpdate(int $id)
    {
        try{

            $update = ProjectUpdate::findOrFail($id);

            return $update->delete();

        }catch(\Exception $e){

            Log::error('Delete Project Update Error: '.$e->getMessage());
            return null;

        }
    }

}