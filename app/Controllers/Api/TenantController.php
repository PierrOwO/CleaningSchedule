<?php

namespace App\Controllers\Api;

use App\Services\TenantService;
use Support\Vault\Http\Request;

class TenantController
{
    protected TenantService $service;

    public function __construct() {
        $this->service = new TenantService();
    }
    public function index()
    {
        // GET /users
    }

    public function show($id)
    {
        $result = $this->service->get($id);
        if(!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => 'No data found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'tenant' => $result['tenant']
        ]);
    }

    public function store(Request $request)
    {
        $room = $request->input('room');
        $user = $request->input('user');

        if (empty($room) || empty($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Empty conditions'
            ], 422);
        }

        $result = $this->service->new($room, $user);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create house'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tenant added successfully',
        ], 201);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $room = $request->input('room');
        $user = $request->input('user');
        $status = $request->input('status');

        if (empty($room) || empty($user) || empty($status)) {
            return response()->json([
                'success' => false,
                'message' => 'Empty conditions'
            ], 422);
        }

        $result = $this->service->update($id, $room, $user, $status);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message']
        ], 201);
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        
        $result = $this->service->check($id);
        if(!$result['success']){
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 500);
        }
        $delete = $this->service->delete($id);
        if (!$delete['success']){
            return response()->json([
                'success' => false,
                'message' => $delete['message']
            ], 500);
        }
        return response()->json([
            'success' => true,
            'message' => $delete['message']
        ], 201);

    }
}