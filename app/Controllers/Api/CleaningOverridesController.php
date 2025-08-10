<?php

namespace App\Controllers\Api;

use App\Services\CleaningOverridesService;
use Support\Vault\Http\Request;

class CleaningOverridesController
{
    protected CleaningOverridesService $service;

    public function __construct() {
        $this->service = new CleaningOverridesService();
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
        $house = $request->input('house');
        $room = $request->input('room');
        $tenat = $request->input('tenat');
        $week = $request->input('week');
        $year = $request->input('year');

        if (empty($house) || empty($room) || empty($tenat) || empty($week) || empty($year)) {
            return response()->json([
                'success' => false,
                'message' => 'Empty conditions'
            ], 422);
        }

        $result = $this->service->new($house, $room, $tenat, $week, $year);

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

    public function update(Request $request)
    {
        $id = $request->input('id');
        $house = $request->input('house');
        $room = $request->input('room');
        $tenat = $request->input('tenat');
        $week = $request->input('week');
        $year = $request->input('year');

        if (empty($id) || empty($house) || empty($room) || empty($tenat) || empty($week) || empty($year)) {
            return response()->json([
                'success' => false,
                'message' => 'Empty conditions'
            ], 422);
        }

        $result = $this->service->update($id, $house, $room, $tenat, $week, $year);

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