<?php

namespace App\Services;

use App\Models\Room;

class RoomService
{
    public function check(string $id): array
    {
        $room = Room::where('unique_id', $id)->first();
        if(!$room){
            return [
                'success' => false
            ];
        }
        return [
            'success' => true,
        ];
    }
    public function new(string $room, int $number): array
    {   
        $room = new Room;
        $room->number = $number;
        $room->Room = $room;
        $result = $room->save();
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
    public function get(string $id): array
    {
        $room = Room::where('unique_id', $id)->first();
        if (!$room) {
            return [
                'success' => false,
                'message' => 'No data found'
            ];
        }
        return [
            'success' => true,
            'message' => 'Data found',
            'Room' => $room
        ];
    }
    public function update(string $id, string $number, string $house)
    {
        $room = Room::where('unique_id', $id)->first();
        if (!$room) {
            return [
                'success' => false,
                'message' => 'No data found'
            ];
        }

        $room->number = $number;
        $room->house = $house;
        $result = $room->save();

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
        $delete = Room::where('unique_id', $id)->delete();
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