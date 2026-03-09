<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProjectRequest extends FormRequest
{

    public function authorize(): bool
    {
        return Auth::user()?->isAdmin();
    }

    public function rules(): array
    {
        return [

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'developer_id' => [
                'required',
                'exists:users,id'
            ],

            'client_id' => [
                'required',
                'exists:users,id'
            ],

            'status' => [
                'nullable',
                'in:pending,in_progress,completed'
            ],

            'start_date' => [
                'nullable',
                'date'
            ],

            'deadline' => [
                'nullable',
                'date',
                'after_or_equal:start_date'
            ]
        ];
    }

    public function messages(): array
    {
        return [

            'title.required' => 'Project title is required.',

            'developer_id.required' => 'Developer must be selected.',
            'developer_id.exists' => 'Invalid developer selected.',

            'client_id.required' => 'Client must be selected.',
            'client_id.exists' => 'Invalid client selected.',

            'deadline.after_or_equal' => 'Deadline must be after start date.'
        ];
    }

}