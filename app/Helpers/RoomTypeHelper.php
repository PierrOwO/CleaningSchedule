<?php

namespace App\Helpers;

class RoomTypeHelper
{
    public static function check($type)
    {
        switch ($type) {
            case 'room': return 'Room';
            case 'bedroom': return 'Bedroom';
            case 'kitchen': return 'Kitchen';
            case 'living_room': return 'Living room';
            case 'dining_room': return 'Dining room';
            case 'bathroom': return 'Bathroom';
            case 'toilet': return 'Toilet';
            case 'office': return 'Office';
            case 'garage': return 'Garage';
            case 'attic': return 'Attic';
            case 'basement': return 'Basement';
            case 'laundry': return 'Laundry';
            case 'pantry': return 'Pantry';
            case 'hallway': return 'Hallway';
            case 'closet': return 'Closet';
            case 'porch': return 'Porch';
            case 'balcony': return 'Balcony';
            case 'terrace': return 'Terrace';
            default: return ucfirst(str_replace('_', ' ', $type));
        }
    }
}