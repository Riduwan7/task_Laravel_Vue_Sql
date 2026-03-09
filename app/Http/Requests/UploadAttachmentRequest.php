<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UploadAttachmentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return Auth::user()?->isDeveloper();
    }

    public function rules(): array
    {
        return [

            'project_update_id' => [
                'required',
                'exists:project_updates,id'
            ],

            'file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx,zip',
                'max:10240'
            ]
        ];
    }

    public function messages(): array
    {
        return [

            'file.required' => 'File is required.',
            'file.mimes' => 'Invalid file type.',
            'file.max' => 'File size cannot exceed 10MB.'
        ];
    }

}