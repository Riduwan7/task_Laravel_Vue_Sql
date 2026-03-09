<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadAttachmentRequest;
use App\Services\AttachmentService;
use Illuminate\Http\JsonResponse;

class AttachmentController extends Controller
{

    protected AttachmentService $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function upload(UploadAttachmentRequest $request): JsonResponse
    {

        $attachment = $this->attachmentService
            ->uploadAttachment(
                $request->file('file'),
                $request->project_update_id
            );

        if($attachment){
            return response()->json([
                'success'=>true,
                'message'=>'Attachment uploaded.',
                'data'=>$attachment
            ]);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Upload failed.'
        ],500);
    }

    public function destroy($id): JsonResponse
    {

        $deleted = $this->attachmentService
            ->deleteAttachment($id);

        if($deleted){
            return response()->json([
                'success'=>true,
                'message'=>'Attachment deleted.'
            ]);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Delete failed.'
        ],500);
    }

}