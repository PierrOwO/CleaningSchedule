<?php

namespace App\Services;

use App\Models\House;

class HouseService
{
    public function new(string $name, string $address): array
    {   
        while (true)
        {
            $slug = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnoprstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ", 10)), 0, 10);
            $codeExists = House::where('BINARY slug', $slug)->first();
            if(!$codeExists)
            {
                break;
            }
        }
        $house = new House;
        $house->name = $name;
        $house->address = $address;
        $house->slug = $slug;
        $house->founder = auth()->user()->unique_id;
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