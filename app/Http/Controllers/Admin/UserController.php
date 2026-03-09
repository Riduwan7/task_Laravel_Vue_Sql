<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('admin.users.list');
    }

    public function data(Request $request)
    {
        return $this->userService->getDataTablesData();
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'data' => $user
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'User creation failed.'
        ], 500);
    }

    public function edit(string $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {

        $updatedUser = $this->userService->updateUser(
            $id,
            $request->validated()
        );

        if ($updatedUser) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully.',
                'data' => $updatedUser
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User update failed.'
        ], 500);
    }

    public function destroy(string $id): JsonResponse
    {

        $deleted = $this->userService->deleteUser($id);

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Delete failed.'
        ], 500);
    }

    public function developers()
    {
        $developers = \App\Models\User::where('role', 'developer')
            ->select('id', 'name')
            ->get();

        return response()->json($developers);
    }

    public function clients()
    {
        $clients = \App\Models\User::where('role', 'client')
            ->select('id', 'name')
            ->get();

        return response()->json($clients);
    }
}
