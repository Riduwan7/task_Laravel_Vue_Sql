<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProjectUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return Auth::user()?->isDeveloper();
    }

    public function rules(): array
    {

        return [

            'note' => [
                'required',
                'string'
            ],

            'status' => [
                'required',
                'in:pending,in_progress,completed'
            ]
        ];
    }

}