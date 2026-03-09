<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProjectUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return Auth::user()?->isDeveloper();
    }

    public function rules(): array
    {

        return [

            'project_id' => [
                'required',
                'exists:projects,id'
            ],

            'note' => [
                'required',
                'string'
            ],

            'status' => [
                'required',
                'in:pending,in_progress,completed'
            ],

            'attachment' => [
                'nullable',
                'file',
                'max:5120'
            ]

        ];
    }

}