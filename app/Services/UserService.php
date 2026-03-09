<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserService
{
    public function getDataTablesData()
    {
        $users = User::query()
            ->orderBy('created_at', 'desc');

        return DataTables::of($users)

            ->editColumn('role', function ($user) {
                return ucfirst($user->role);
            })

            ->addColumn('action', function ($user) {

                $currentUser = Auth::user();

                if (!$currentUser || !$currentUser->isAdmin()) {
                    return '';
                }

                return '
                    <button class="btn btn-sm btn-primary edit-user"
                        data-id="' . $user->id . '">
                        Edit
                    </button>

                    <button class="btn btn-sm btn-danger delete-user"
                        data-id="' . $user->id . '">
                        Delete
                    </button>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function getAllUsers()
    {
        try {
            return User::orderBy('name')->get();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function getDevelopers()
    {
        return User::where('role', 'developer')->get();
    }

    public function getClients()
    {
        return User::where('role', 'client')->get();
    }

    public function createUser(array $data)
    {
        try {

            $data['password'] = Hash::make($data['password']);

            return User::create($data);
        } catch (\Exception $e) {

            Log::error('Create User Error: ' . $e->getMessage());
            return null;
        }
    }

    public function updateUser(int $id, array $data)
    {
        try {

            $user = User::findOrFail($id);

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);

            return $user;
        } catch (\Exception $e) {

            Log::error('Update User Error: ' . $e->getMessage());
            return null;
        }
    }

    public function deleteUser(int $id)
    {
        try {

            $user = User::findOrFail($id);

            return $user->delete();
        } catch (\Exception $e) {

            Log::error('Delete User Error: ' . $e->getMessage());
            return null;
        }
    }

    public function getUserById(int $id)
    {
        return User::findOrFail($id);
    }

    public function getClientsData()
    {
        $clients = \App\Models\User::where('role', 'client')
            ->latest()
            ->get();

        return response()->json([
            'data' => $clients
        ]);
    }
}
