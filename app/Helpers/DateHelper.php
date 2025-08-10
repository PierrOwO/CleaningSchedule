<?php
namespace App\Helpers;

use DateTime;

class DateHelper
{
    public static function formatDate($date)
    {
        return date('d.m.Y', strtotime($date));
    }

    public static function now()
    {
        return date('Y-m-d H:i:s');
    }
    public static function nowFormated()
    {
        return self::formatDate(self::now());
    }
    public static function getCurrentWeekNumber(): int {
        return (int) date('W');
    }
    public static function getRoomForDate(string $date): int {
        $rooms = [7, 8, 11];
        
        $baseDate = new DateTime('2025-01-06');
        $targetDate = new DateTime($date);
    
        $baseWeek = (int) $baseDate->format('W');
        $baseYear = (int) $baseDate->format('o');
    
        $targetWeek = (int) $targetDate->format('W');
        $targetYear = (int) $targetDate->format('o');
    
        $weeksDiff = ($targetYear - $baseYear) * 52 + ($targetWeek - $baseWeek);
    
        $index = ($weeksDiff % count($rooms) + count($rooms)) % count($rooms);
    
        return $rooms[$index];
    }
    public static function thisWeekSchelude(): int
    {
        return self::getRoomForDate(date('Y-m-d'));
    }
    public static function nextWeekSchelude(): int
    {
        $date = new DateTime(); 
        $date->modify('+1 week');
        return self::getRoomForDate($date->format('Y-m-d'));
    }
    public static function previousWeekSchelude(): int
    {
        $date = new DateTime(); 
        $date->modify('-1 week');
        return self::getRoomForDate($date->format('Y-m-d'));
    }
}
