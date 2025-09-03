@php
use App\Helpers\RoomTypeHelper;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View schedule</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
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
        h1 {
            color: #333;
            margin-bottom: 1rem;
        }
        p {
            color: #555;
        }
    </style>
    @vite('/js/schedule.js')
</head>
<body>
    <div class="container">
        <label>Select House</label>
        <select id="select-choose-house" onchange="selectHouse()">
            
        @if ($houses && !empty($houses) && $houses != null)
            <option value="">Select house...</option>
            @foreach ($houses as $house)
            <option id="{{$house->id}}" name="{{$house->name}}" value="{{$house->unique_id}}">{{$house->name}},  {{$house->address}} -- {{$house->id}},  {{$house->unique_id}}</option>
            @endforeach
        @else
            <option value="">No houses found</option>
        @endif
        </select>
    </div>
    <div class="container">
        <label>Room</label>
        <select id="select-tenant-room">
        @if ($chceckedHouse)
            @if ($bedrooms && !empty($bedrooms) && $bedrooms != null)
                @foreach ($bedrooms as $room)
                <option value="{{$room->unique_id}}">Room number {{$room->number}}, type: {{ RoomTypeHelper::check($room->type) }} </option>
                @endforeach
            @else
                <option value="">No rooms found</option>
            @endif
        @else
            <option value="">Select House first</option>
        @endif
        </select>
        <label>User</label>
        <select id="select-tenant-user">
        @if ($users && !empty($users) && $users != null)
            @foreach ($users as $user)
            <option value="{{$user->unique_id}}">{{$user->first_name}} {{$user->last_name}}</option>
            @endforeach
        @else
            <option value="">No users found</option>
        @endif
        </select>
        <button id="button-create-tenant">add tenant</button>
    </div>
  
    <script>
        function selectHouse(){
            const select = document.getElementById('select-choose-house')
            const selected = select.options[select.selectedIndex];

            const value = selected.value;      
            const id = selected.id;            
            const name = selected.getAttribute("name"); 

            //let url = '/schedule/tenants/' + selectedHouse;
            let url = '/schedule/tenants/' + name + '-' + id;
            window.location.href = url;
        }
    </script>
</body>
</html>