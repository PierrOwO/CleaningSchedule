<?php

namespace App\Controllers\Api;

use App\Services\HouseService;
use Support\Vault\Http\Request;

class HouseController
{
    protected HouseService $service;

    public function __construct() {
        $this->service = new HouseService();
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
            'house' => $result['house']
        ]);
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $address = $request->input('address');

        if (empty($name) || empty($address)) {
            return response()->json([
                'success' => false,
                'message' => 'Name and address are required'
            ], 422);
        }

        $result = $this->service->new($name, $address);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create house'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'House created successfully',
            'house' => $result['house']
        ], 201);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $address = $request->input('address');

        if (empty($name) || empty($address)) {
            return response()->json([
                'success' => false,
                'message' => 'Name and address are required'
            ], 422);
        }

        $result = $this->service->update($id, $name, $address);

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