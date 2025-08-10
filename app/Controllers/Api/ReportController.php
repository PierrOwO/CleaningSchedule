<?php

namespace App\Controllers\Api;

use App\Services\ReportService;
use Support\Vault\Http\Request;

class ReportController
{
    protected ReportService $service;

    public function __construct() {
        $this->service = new ReportService();
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

        if (empty($name)) {
            return response()->json([
                'success' => false,
                'message' => 'Empty conditions'
            ], 422);
        }

        $result = $this->service->new($name, 1);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
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
        $status = $request->input('status');

        if (empty($name) || empty($status)) {
            return response()->json([
                'success' => false,
                'message' => 'Empty conditions'
            ], 422);
        }

        $result = $this->service->update($id, $name, $status);

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