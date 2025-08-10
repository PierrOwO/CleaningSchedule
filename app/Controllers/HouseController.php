<?php

namespace App\Controllers;

use App\Models\House;
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
        // ...
    }

    public function new(Request $request)
    {
        $name = $request->input('name');
        $address = $request->input('address');

        $result = $this->service->new($name, $address);
        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => "Couldn't create house"
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'House created successfully'
        ]);
    }

    public function get($id)
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
}