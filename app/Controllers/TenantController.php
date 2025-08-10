<?php

namespace App\Controllers;

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
        // ...
    }
    
    public function new(Request $request)
    {
        $room = $request->input('room');
        $user = $request->input('user');

        $result = $this->service->new($room, $user);
        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => "Couldn't add tenant"
                ], 500);
        }
        return response()->json([
            'success' => true,
            'message' => 'Tenant added successfully'
        ]);
        
    }
}