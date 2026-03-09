<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProjectRequest extends FormRequest
{

    public function authorize(): bool
    {
        return Auth::user()?->isAdmin();
    }

    public function rules(): array
    {

        return [

            'title' => ['required','string','max:255'],

            'description' => ['nullable','string'],

            'developer_id' => [
                'required',
                'exists:users,id'
            ],

            'client_id' => [
                'required',
                'exists:users,id'
            ],

            'status' => [
                'required',
                'in:pending,in_progress,completed'
            ],

            'start_date' => ['nullable','date'],

            'deadline' => [
                'nullable',
                'date',
                'after_or_equal:start_date'
            ]
        ];
    }

}