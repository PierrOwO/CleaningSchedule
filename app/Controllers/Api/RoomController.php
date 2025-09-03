<?php

namespace App\Controllers\Api;

use App\Services\RoomService;
use Support\Vault\Http\Request;

class RoomController
{
    protected RoomService $service;

    public function __construct() {
        $this->service = new RoomService();
    }
    public function index()
    {
        // GET /users
    }
    public function getBedroomsByHouse($id)
    {
        $result = $this->service->getBedroomsByHouse($id);
        if(!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => 'No data found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'rooms' => $result['rooms']
        ]);
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
        $number = $request->input('number');
        $house = $request->input('house');
        $type = $request->input('type');


        if (empty($number) || empty($house) || empty($type)) {
            return response()->json([
                'success' => false,
                'message' => 'Room number and house are required'
            ], 422);
        }

        $result = $this->service->new($house, $number, $type);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create room'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Room created successfully',
        ], 201);
    }

    public function update($id)
    {
        $number = request()->input('number');
        $house = request()->input('house');
        $type = request()->input('type');


        if (empty($number) || empty($house) || empty($type)) {
            return response()->json([
                'success' => false,
                'message' => 'Room number and house are required'
            ], 422);
        }

        $result = $this->service->update($id, $number, $house, $type);

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