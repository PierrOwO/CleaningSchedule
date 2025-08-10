<?php

namespace App\Controllers;

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
        // ...
    }
    
    public function new(Request $request)
    {
        $number = $request->input('number');
        $house = $request->input('house');

        $result = $this->service->new($number, $house);
        if (!$result['success']) {
            return response()->json([
                'success' => false, 
                'message' => "Couldn't create room"
            ], 500);
        }
        return response()->json([
            'success' => true,
            'message' => 'Room created successfully'
        ]);
    }
}