<?php

namespace App\Services;

use App\Models\CleaningOverride;

class CleaningOverridesService
{
    public function new(string $house, string $room, string $tenant, int $week, int $year): array
    {   
        $cleaningOverride = new CleaningOverride;
        $cleaningOverride->house = $house;
        $cleaningOverride->room = $room;
        $cleaningOverride->tenant = $tenant;
        $cleaningOverride->week = $week;
        $cleaningOverride->year = $year;
        $result = $cleaningOverride->save();
        if (!$result) {
            return [
                'success' => false,
                'message' => 'an error appeared while processing',
            ];
        }
        
        return [
            'success' => true,
            'message' => 'Created successfully'
        ];
    }
    
    public function check(string $id): array
    {
        $cleaningOverride = CleaningOverride::find($id);;
        if(!$cleaningOverride){
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
        $cleaningOverride = CleaningOverride::find($id);;
        if (!$cleaningOverride) {
            return [
                'success' => false,
                'message' => 'No data found'
            ];
        }
        return [
            'success' => true,
            'message' => 'Data found',
            'cleaningOverride' => $cleaningOverride
        ];
    }
    public function update(string $id, string $house, string $room, string $tenant, int $week, int $year)
    {
        $cleaningOverride = CleaningOverride::find($id);;
        if (!$cleaningOverride) {
            return [
                'success' => false,
                'message' => 'No data found'
            ];
        }

        $cleaningOverride->house = $house;
        $cleaningOverride->room = $room;
        $cleaningOverride->tenant = $tenant;
        $cleaningOverride->week = $week;
        $cleaningOverride->year = $year;
        $result = $cleaningOverride->save();

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
        $delete = CleaningOverride::find($id)->delete();
        
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