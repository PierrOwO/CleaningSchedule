<?php
namespace App\Helpers;

use DateTime;
use Support\Vault\Sanctum\Log;

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
    public static function getScheduleForDate($startDate, $plan, $targetDate = null): array
    {
        $targetDate = $targetDate ?? date('Y-m-d');
        $startDate = $startDate ?? date('Y-m-d');
        
        $baseDate = new DateTime($startDate);
        $target = new DateTime($targetDate);

        // różnica w tygodniach
        $baseWeek = (int) $baseDate->format('W');
        $baseYear = (int) $baseDate->format('o');

        $targetWeek = (int) $target->format('W');
        $targetYear = (int) $target->format('o');

        $weeksDiff = ($targetYear - $baseYear) * 52 + ($targetWeek - $baseWeek);

        // plan ma np. 6 tygodni -> rotacja co 6
        $planLength = count($plan);
        $index = ($weeksDiff % $planLength + $planLength) % $planLength;

        return [
            'weekIndex' => $index,
            'plan' => $plan[$index] ?? []
        ];
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
