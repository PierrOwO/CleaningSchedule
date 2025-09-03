<?php

namespace App\Services;

use App\Models\CleaningQueue;
use App\Models\House;
use App\Models\Room;
use App\Models\User;
use Support\Vault\Sanctum\Log;

class ScheduleService
{
    
    public function getUsers()
    {
        $users = User::all();
        if (!$users)
        {
            return [
                'success' => false,
                'users' => null,
            ];
        }
        return [
            'success' => true,
            'users' => $users,
        ];
    }
    public function getHouses()
    {
        $houses = House::all();
        if (!$houses)
        {
            return [
                'success' => false,
                'houses' => null,
            ];
        }
        return [
            'success' => true,
            'houses' => $houses,
        ];   
    }
    public function checkHouse($ID)
    {
        $house = House::where('unique_id', $ID)->first();
        if (!$house)
        {
            Log::info('no house found');
            return [
                'success' => false,
            ];
        }
        Log::info('house found');
        return [
            'success' => true,
        ];   
    }
    public function checkHouseByNameAndId($Name, $ID)
    {
        $house = House::where('id', $ID)
                    ->where('name', $Name)
                    ->first();
        if (!$house)
        {
            return [
                'success' => false,
            ];
        }
        return [
            'success' => true,
            'houseId' => $house->unique_id,
        ];   
    }
    public function getCountHousesByUserId($userID)
    {
        $totalHouses = House::where('founder', $userID)->count();
        $houses = [];
        if($totalHouses > 0)
        {
            $houses = House::where('founder', $userID)->get();
        }
        return [
            'success' => true,
            'totalHouses' => $totalHouses,
            'houses' => $houses
        ];   
    }
    public function checkHouseBySlug($slug)
    {
        $house = House::where('BINARY slug', $slug)->first();
        if (!$house)
        {
            return [
                'success' => false,
            ];
        }
        return [
            'success' => true,
            'houseId' => $house->unique_id,
            'name' => $house->name,
        ];   
    }
    public function getBedrooms($house)
    {
        $rooms = Room::where('house', $house)
                    ->where('type', 'bedroom')
                    ->get();
        if (!$rooms)
        {
            return [
                'success' => false,
                'rooms' => null,
            ];
        }
        return [
            'success' => true,
            'rooms' => $rooms,
        ];
    }
    public function getRooms($house)
    {
        $rooms = Room::where('house', $house)
                    ->get();
        if (!$rooms)
        {
            return [
                'success' => false,
                'rooms' => null,
            ];
        }
        return [
            'success' => true,
            'rooms' => $rooms,
        ];
    }
    public function getRoomsNotBedroom($house)
    {
        $rooms = Room::where('house', $house)
                    ->where('type', '!=', 'bedroom')
                    ->get();
        if (!$rooms)
        {
            return [
                'success' => false,
                'rooms' => null,
            ];
        }
        return [
            'success' => true,
            'rooms' => $rooms,
        ];
    }
    public function getTotalRooms($house)
    {
        $rooms = Room::where('house', $house)
                    ->get();
        if (!$rooms)
        {
            return [
                'success' => false,
                'totalRooms' => 0,
            ];
        }
        $totalRooms = Room::where('house', $house)
                        ->count();
        return [
            'success' => true,
            'totalRooms' => $totalRooms,
        ];
    }
    public function getTotalRoomsNotBedroom($house)
    {
        $rooms = Room::where('house', $house)
                    ->where('type', '!=', 'bedroom')
                    ->get();
        if (!$rooms)
        {
            return [
                'success' => false,
                'totalRooms' => 0,
            ];
        }
        $totalRooms = Room::where('house', $house)
                        ->where('type', '!=', 'bedroom')
                        ->count();
        return [
            'success' => true,
            'totalRooms' => $totalRooms,
        ];
    }
    public function getTotalBedrooms($house)
    {
        $rooms = Room::where('house', $house)
                    ->where('type', 'bedroom')
                    ->get();
        if (!$rooms)
        {
            return [
                'success' => false,
                'totalRooms' => 0,
            ];
        }
        $totalRooms = Room::where('house', $house)
                        ->where('type', 'bedroom')
                        ->count();
        return [
            'success' => true,
            'totalRooms' => $totalRooms,
        ];
    }
    public function getCleaningQueue($id)
    {
        $result = CleaningQueue::where('house', $id)->first();
        if (!$result)
        {
            return [
                'success' => false,
                'queue' => [],
            ];
        }
        $type = $result->type;
        $rotation = $result->rotation;
        $startDate = $result->start_date;
        $data = [
            'type' => $type,
            'rotation' => $rotation
        ];
        return [
            'success' => true,
            'type' => $type,
            'rotation' => $rotation,
            'startDate' => $startDate,
        ];
    }
}