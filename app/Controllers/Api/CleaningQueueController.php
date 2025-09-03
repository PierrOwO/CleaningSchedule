<?php

namespace App\Controllers\Api;

use App\Services\CleaningQueueService;
use Support\Vault\Http\Request;

class CleaningQueueController
{
    protected CleaningQueueService $service;

    public function __construct() {
        $this->service = new CleaningQueueService();
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
            'queue' => $result['queue']
        ]);
    }

    public function store(Request $request)
    {
        $house = $request->input('house');
        $json = $request->input('json');
        $start_date = $request->input('start_date');
        $type = $request->input('type');

        if (empty($house) || empty($json)) {
            return response()->json([
                'success' => false,
                'message' => 'Empty data sent'
            ], 422);
        }

        $result = $this->service->new($house, $json, $start_date, $type);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'House created successfully',
        ], 201);
    }

    public function update($id)
    {
        $json = request()->input('json');
        $start_date = request()->input('start_date');
        $type = request()->input('type');


        $result = $this->service->update($id, $json, $start_date, $type);

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

    public function destroy($id)
    {        
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