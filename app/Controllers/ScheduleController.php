<?php

namespace App\Controllers;

use App\Helpers\DateHelper;
use App\Models\CleaningQueue;
use App\Services\CleaningQueueService;
use App\Services\ScheduleService;
use DateTime;
use Support\Vault\Sanctum\Log;

class ScheduleController
{
    protected ScheduleService $service;

    public function __construct() {
        $this->service = new ScheduleService();
    }

    public function index()
    {           
        $houses = $this->service->getHouses();
        return view('schedule', [
            'houses' => $houses['houses'], 
        ]);
    }
    public function viewDashboard()
    {
        $role = auth()->user()->role;
        switch ($role)
        {
            case 'admin':
                $result = $this->service->getCountHousesByUserId(auth()->user()->unique_id);
                return view('admin.dashboard', [
                    'totalHouses' => $result['totalHouses'],
                    'houses' => $result['houses']
                ]);
                break;
            case 'founder':
                $result = $this->service->getCountHousesByUserId(auth()->user()->unique_id);
                return view('founder.dashboard', [
                    'totalHouses' => $result['totalHouses'],
                    'houses' => $result['houses']
                ]);
                break;
            case 'tenant':
                return view('tenant.dashboard');
                break;
            default:
                return view('admin.dashboard');
                break;
        }
    }
    public function viewCreateHouse()
    {
        $role = auth()->user()->role;
        switch ($role)
        {
            case 'admin':
                return view('createHouse');
                break;
            case 'founder':
                return view('createHouse');
                break;
            default:
                return redirect('/');
                break;
        }
    }
    public function viewCreateRooms()
    {
        $role = auth()->user()->role;
        switch ($role)
        {
            case 'admin':
                $result = $this->service->getCountHousesByUserId(auth()->user()->unique_id);
                return view('createRooms', [
                    'totalHouses' => $result['totalHouses'],
                    'houses' => $result['houses']
                ]);
                break;
            case 'founder':
                $result = $this->service->getCountHousesByUserId(auth()->user()->unique_id);
                return view('createRooms', [
                    'totalHouses' => $result['totalHouses'],
                    'houses' => $result['houses']
                ]);
                break;
            default:
                return redirect('/');
                break;
        }
    }
    public function viewMakePlan($house = null)
    {
        $house = str_replace('%20', ' ', $house);
        $role = auth()->user()->role;
        Log::info("house: " . $house);
        switch ($role)
        {
            case 'admin':
                $this->makePlan($house);
                break;
            case 'founder':
                $this->makePlan($house);
                break;
            default:
                return redirect('/');
                break;
        }
    }

    public function addTenant($house = null)
    {   
        $chceckedHouse = false;
        $ID = null;
        $bedrooms = '';

        if(!empty($house) && $house != null)
        {
            $houseData = explode('-', $house);
            $houseId = $houseData[1];
            $houseName = $houseData[0];
            if(!empty($houseId) && !empty($houseName)){
                $checkHouseResult = $this->service->checkHouseByNameAndId($houseName, $houseId);
                if($checkHouseResult['success']){
                    $ID = $checkHouseResult['houseId'];
                    $chceckedHouse = true;
                }
            }
        }
        
        
        $users = $this->service->getUsers();
        $houses = $this->service->getHouses();
        $bedroomsResult = $this->service->getBedrooms($ID);
        if ($bedroomsResult['success']){
            $bedrooms = $bedroomsResult['rooms'];
        }
        
        
        return view('addTenant', [
            'users' => $users['users'], 
            'houses' => $houses['houses'], 
            'bedrooms' => $bedrooms, 
            'chceckedHouse' => $chceckedHouse
        ]);
    }  
    public function makePlan($house = null)
    { 
        $chceckedHouse = false;
        $ID = null;
        $bedrooms = '';
        $rooms = '';


        if(!empty($house) && $house != null)
        {
            $houseData = explode('-', $house);
            $houseId = $houseData[1];
            $houseName = $houseData[0];
            if(!empty($houseId) && !empty($houseName)){
                $checkHouseResult = $this->service->checkHouseByNameAndId($houseName, $houseId);
                if($checkHouseResult['success']){
                    $ID = $checkHouseResult['houseId'];
                    $chceckedHouse = true;
                }
            }
        }
        $bedroomsResult = $this->service->getBedrooms($ID);
        if ($bedroomsResult['success']){ $bedrooms = $bedroomsResult['rooms']; }
        $roomsResult = $this->service->getRoomsNotBedroom($ID);
        if ($roomsResult['success']){ $rooms = $roomsResult['rooms']; }
        $totalBedrooms = $this->service->getTotalBedrooms($ID);
        $totalRooms = $this->service->getTotalRoomsNotBedroom($ID);
        Log::debug("data", [
            'bedrooms' => $bedrooms, 
            'rooms' => $rooms, 
            'totalBedrooms' => $totalBedrooms['totalRooms'], 
            'totalRooms' => $totalRooms['totalRooms'], 
            'chceckedHouse' => $chceckedHouse
        ]);
        return view('makePlan', [
            'bedrooms' => $bedrooms, 
            'rooms' => $rooms, 
            'totalBedrooms' => $totalBedrooms['totalRooms'], 
            'totalRooms' => $totalRooms['totalRooms'], 
            'chceckedHouse' => $chceckedHouse,
            'houseID' => $ID
        ]);
    }
    public function showSchedule($house)
    {
        $houseData = explode('-', $house);
        $houseId = $houseData[1];
        $houseName = $houseData[0];
        $checkHouseResult = $this->service->checkHouseByNameAndId($houseName, $houseId);
            if(!$checkHouseResult['success']){
                echo "Couldn't find cleaning schedule";
                exit();
            }
            else{
                $ID = $checkHouseResult['houseId'];
            }
        $queue = $this->service->getCleaningQueue($ID);
        if(!$queue['success']){
            $response = ['error' => 404,
            'message'=> "Couldn't find cleaning schedule"
            ];
            echo "Couldn't find cleaning schedule";
        }
        $plan = json_decode($queue['rotation'], true);
        $result = DateHelper::getScheduleForDate($queue['startDate'], $plan);

        $previousWeek = new DateTime(); 
        $nextWeek = new DateTime(); 
        $previousWeek->modify('-1 week');
        $nextWeek->modify('+1 week');
        $nextWeekPlan = DateHelper::getScheduleForDate($queue['startDate'], $plan, $nextWeek->format('Y-m-d'));
        $previousWeekPlan = DateHelper::getScheduleForDate($queue['startDate'], $plan, $previousWeek->format('Y-m-d'));
        return view('showSchedule', [
            'plan' => $result,
            'nextWeekPlan' => $nextWeekPlan,
            'previousWeekPlan' => $previousWeekPlan,
        ]);

    }
    public function scheduleBySlug($slug)
    {
       
        $checkHouseResult = $this->service->checkHouseBySlug($slug);
        if(!$checkHouseResult['success']){
            echo "Couldn't find cleaning schedule";
            exit();
        }
        $ID = $checkHouseResult['houseId'];
        $houseName = $checkHouseResult['name'];
        echo $houseName;
    }
}