<?php

namespace App\Services;

use App\Models\Tenant;

class TenantService
{
    public function new(string $room, string $user): array
    {   
        //$house = Tenant::where('room', $room)->value('unique_id');

        $tenant = new Tenant;
        $tenant->room = $room;
        $tenant->user = $user;
        $tenant->status = 1;
        $result = $tenant->save();
        if (!$result) {
            return [
                'success' => false,
                'message' => 'an error appeared while processing',
            ];
        }
        
        return [
            'success' => true,
        ];
    }

    public function check(string $id): array
    {
        $tenant = Tenant::where('unique_id', $id)->first();
        if(!$tenant){
            return [
                'success' => false
            ];
        }
        return [
            'success' => true,
        ];
    }

    public function get(string $id): array
    {
        $tenant = Tenant::where('unique_id', $id)->first();
        if (!$tenant) {
            return [
                'success' => false,
                'message' => 'No data found'
            ];
        }
        return [
            'success' => true,
            'message' => 'Data found',
            'tenant' => $tenant
        ];
    }
    public function update(string $id, string $room, string $user, string $status)
    {
        $tenant = Tenant::where('unique_id', $id)->first();
        if (!$tenant) {
            return [
                'success' => false,
                'message' => 'No data found'
            ];
        }

        $tenant->room = $room;
        $tenant->user = $user;
        $tenant->status = $status;
        $result = $tenant->save();

        if (!$result){
            return [
                'success' => false,
                'message' => 'Update failed'
            ];
        }

        return [
            'success' => true,
            'message' => 'Updated successfully'
        ];
    }
    
    public function delete(string $id): array
    {
        $delete = Tenant::where('unique_id', $id)->delete();
        
        if(!$delete){
            return [
                'success' => false,
                'message' => 'Delete failed'
            ];
        }

        return [
            'success' => true,
            'message' => 'Deleted successfully'
        ];
    }
}