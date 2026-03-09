<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class StoreUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        $user = Auth::user();

        return $user && $user->isAdmin();
    }

    public function rules(): array
    {
        return [

            'name' => ['required','string','max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],

            'role' => [
                'required',
                Rule::in(['admin','developer','client'])
            ]
        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'User name is required.',

            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'Email already exists.',

            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',

            'role.required' => 'User role is required.',
            'role.in' => 'Invalid user role selected.'
        ];
    }

}