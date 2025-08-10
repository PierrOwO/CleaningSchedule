<?php

namespace App\Services;

use App\Models\House;

class HouseService
{
    public function new(string $name, string $address): array
    {   
        $house = new House;
        $house->name = $name;
        $house->address = $address;
        $result = $house->save();
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
        $house = House::where('unique_id', $id)->first();
        if(!$house){
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
        $house = House::where('unique_id', $id)->first();
        if (!$house) {
            return [
                'success' => false,
                'message' => 'No data found'
            ];
        }
        return [
            'success' => true,
            'message' => 'Data found',
            'house' => $house
        ];
    }
    public function update(string $id, string $name, string $address)
    {
        $house = House::where('unique_id', $id)->first();
        if (!$house) {
            return [
                'success' => false,
                'message' => 'No data found'
            ];
        }

        $house->name = $name;
        $house->address = $address;
        $result = $house->save();

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
        $delete = House::where('unique_id', $id)->delete();
        
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