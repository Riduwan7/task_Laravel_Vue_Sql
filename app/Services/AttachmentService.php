<?php

namespace App\Services;

use App\Models\ProjectAttachment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AttachmentService
{

    public function uploadAttachment($file,$projectUpdateId)
    {
        try{

            $path = $file->store('project_attachments','public');

            return ProjectAttachment::create([

                'project_update_id' => $projectUpdateId,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize()

            ]);

        }catch(\Exception $e){

            Log::error('Attachment Upload Error: '.$e->getMessage());
            return null;

        }
    }

    public function deleteAttachment(int $id)
    {
        try{

            $attachment = ProjectAttachment::findOrFail($id);

            Storage::disk('public')->delete($attachment->file_path);

            return $attachment->delete();

        }catch(\Exception $e){

            Log::error('Delete Attachment Error: '.$e->getMessage());
            return null;

        }
    }

    public function getAttachmentsByUpdate(int $updateId)
    {
        return ProjectAttachment::where('project_update_id',$updateId)->get();
    }
}