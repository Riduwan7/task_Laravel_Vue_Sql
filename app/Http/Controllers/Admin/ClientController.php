<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('admin.clients.list');
    }

    public function data(Request $request)
    {
        // return only users with role = client
        return $this->userService->getClientsData();
    }

    public function store(StoreUserRequest $request): JsonResponse
    {

        $data = $request->validated();

        // force role to client
        $data['role'] = 'client';

        $client = $this->userService->createUser($data);

        if($client){
            return response()->json([
                'success'=>true,
                'message'=>'Client created successfully.',
                'data'=>$client
            ],201);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Client creation failed.'
        ],500);

    }

    public function show(string $id)
    {

        $client = $this->userService->getUserById($id);

        if(!$client){
            abort(404);
        }

        return view('admin.clients.show',[
            'client'=>$client
        ]);

    }

    public function edit(string $id): JsonResponse
    {

        $client = $this->userService->getUserById($id);

        if(!$client){
            return response()->json([
                'success'=>false,
                'message'=>'Client not found.'
            ],404);
        }

        return response()->json([
            'success'=>true,
            'data'=>$client
        ]);

    }

    public function update(UpdateUserRequest $request,string $id): JsonResponse
    {

        $data = $request->validated();

        $data['role'] = 'client';

        $updatedClient = $this->userService->updateUser(
            $id,
            $data
        );

        if($updatedClient){
            return response()->json([
                'success'=>true,
                'message'=>'Client updated successfully.',
                'data'=>$updatedClient
            ]);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Client update failed.'
        ],500);
    }

    public function destroy(string $id): JsonResponse
    {

        $deleted = $this->userService->deleteUser($id);

        if($deleted){
            return response()->json([
                'success'=>true,
                'message'=>'Client deleted successfully.'
            ]);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Delete failed.'
        ],500);
    }

}