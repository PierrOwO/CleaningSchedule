@php
use App\Helpers\RoomTypeHelper;
use App\Helpers\DateHelper;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cleaning Schedule - plan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        html {
        scroll-behavior: smooth;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 2rem;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .container label{
            display: block;
            width: 50%;
        }
        .container select,
        .container input,
        .container button {
            display: block;
            margin: auto;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding: 0.5rem;
            border: 1px solid #ccc;
            font: inherit;
        }
        .container button:hover{
            background: #bcbcbc;
            cursor: pointer;
        }
        .container select,
        .container input {
            margin-bottom: 10px;
        }
        .container table{
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .container table thead tr{
            background: #808080;
            color: #eaeaea;
        }
        .container table td{
            text-align: center;
            padding: 10px;
        }
        .container table td select,
        .container table td button,
        .container table td input{
            margin: auto;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding: 0.5rem;
            border: 1px solid #ccc;
            font: inherit;
        }
        .container table tbody td{
            padding: 10px;
        }
        #rotation-result tr td:first-child{
            width: 15%;
        }
        #rotation-result tr td:last-child{
            width: 85%;
        }
        #rotation-result tr{
            border-collapse: collapse;
            border: 1px solid #808080;
        }
        #rotation-result tr td:last-child{
            text-align: left;
        }
        .bedroom-data{
            display: inline-block;
            width: 100%;
            text-align: left;
            margin-top: 5px;
        }
        .bedroom-span{
            background-color: #aae3ff;
            border-radius: 5px;
            margin: 5px;
            padding: 5px;
            color: #005d8b;
            font-weight:600; 
        }
        .room-labels-span{
            padding: 5px;
            margin: 5px;
            background-color: #ffcc4c;
            display: inline-block;
            border-radius: 5px;
            color: #a87800;
        }
        .room-labels-span-idle{
            padding: 5px;
            margin: 5px;
            background-color: #52e568;
            display: inline-block;
            border-radius: 5px;
            color: #009d18;
        }
        .week-number{
            padding: 15px;
            background-color: #f66161;
            border-radius: 5px;
            font-weight:500;
            color: #ac0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Today's date {{DateHelper::nowFormated()}}, week {{DateHelper::getCurrentWeekNumber()}}</h2>
            @foreach ($plan['plan'] as $dayIndex => $day)
                <div class="bedroom-data">
                    <span class="bedroom-span">room {{ $day['bedroom']['number'] }}</span>
                    @foreach ($day['rooms'] as $room)
                        @if (!empty($room['id']))
                            <span class="room-labels-span">{{ RoomTypeHelper::check($room['type']) }} nr {{ $room['number'] }}</span>
                        @else
                            <span class="room-labels-span-idle">idle</span>
                        @endif
                    @endforeach
                </div>
            @endforeach
    </div>
    <div class="container">
        <h2>Previous week schedule, week {{(DateHelper::getCurrentWeekNumber() - 1)}}</h2>
            @foreach ($previousWeekPlan['plan'] as $dayIndex => $day)
                <div class="bedroom-data">
                    <span class="bedroom-span">room {{ $day['bedroom']['number'] }}</span>
                    @foreach ($day['rooms'] as $room)
                        @if (!empty($room['id']))
                            <span class="room-labels-span">{{ RoomTypeHelper::check($room['type']) }} nr {{ $room['number'] }}</span>
                        @else
                            <span class="room-labels-span-idle">idle</span>
                        @endif
                    @endforeach
                </div>
            @endforeach
    </div>
    <div class="container">
        <h2>Next week schedule, week {{(DateHelper::getCurrentWeekNumber() + 1)}}</h2>
            @foreach ($nextWeekPlan['plan'] as $dayIndex => $day)
                <div class="bedroom-data">
                    <span class="bedroom-span">room {{ $day['bedroom']['number'] }}</span>
                    @foreach ($day['rooms'] as $room)
                        @if (!empty($room['id']))
                            <span class="room-labels-span">{{ RoomTypeHelper::check($room['type']) }} nr {{ $room['number'] }}</span>
                        @else
                            <span class="room-labels-span-idle">idle</span>
                        @endif
                    @endforeach
                </div>
            @endforeach
    </div>
   
</body>
</html>