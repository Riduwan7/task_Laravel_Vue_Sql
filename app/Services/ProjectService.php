<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProjectService
{

    public function getDataTablesData()
    {

        $projects = Project::with(['developer','client'])
            ->orderBy('created_at','desc');

        return DataTables::of($projects)

            ->addColumn('developer',function($project){
                return $project->developer->name ?? '';
            })

            ->addColumn('client',function($project){
                return $project->client->name ?? '';
            })

            ->editColumn('status',function($project){
                return ucfirst(str_replace('_',' ',$project->status));
            })

            ->addColumn('action',function($project){

                return '
                    <button class="btn btn-sm btn-primary edit-project"
                        data-id="'.$project->id.'">
                        Edit
                    </button>

                    <button class="btn btn-sm btn-danger delete-project"
                        data-id="'.$project->id.'">
                        Delete
                    </button>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function getAllProjects()
    {
        return Project::with(['developer','client'])
            ->latest()
            ->get();
    }

    public function getProjectById(int $id)
    {
        return Project::with(['developer','client','updates'])
            ->findOrFail($id);
    }

    public function createProject(array $data)
    {
        try{

            return Project::create($data);

        }catch(\Exception $e){

            Log::error('Create Project Error: '.$e->getMessage());
            return null;

        }
    }

    public function updateProject(int $id,array $data)
    {
        try{

            $project = Project::findOrFail($id);

            $project->update($data);

            return $project;

        }catch(\Exception $e){

            Log::error('Update Project Error: '.$e->getMessage());
            return null;

        }
    }

    public function deleteProject(int $id)
    {
        try{

            $project = Project::findOrFail($id);

            return $project->delete();

        }catch(\Exception $e){

            Log::error('Delete Project Error: '.$e->getMessage());
            return null;

        }
    }

    public function getDeveloperProjects(int $developerId)
    {
        return Project::where('developer_id',$developerId)->get();
    }

    public function getClientProjects(int $clientId)
    {
        return Project::where('client_id',$clientId)->get();
    }
}