@php
use App\Helpers\RoomTypeHelper;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>make plan</title>
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
        #rotation-result .bedroom-data{
            display: inline-block;
            width: 100%;
            text-align: left;
            margin-top: 5px;
        }
        #rotation-result .bedroom-span{
            background-color: #aae3ff;
            border-radius: 5px;
            margin: 5px;
            padding: 5px;
            color: #005d8b;
            font-weight:600; 
        }
        #rotation-result .room-labels-span{
            padding: 5px;
            margin: 5px;
            background-color: #ffcc4c;
            display: inline-block;
            border-radius: 5px;
            color: #a87800;
        }
        #rotation-result .room-labels-span-idle{
            padding: 5px;
            margin: 5px;
            background-color: #52e568;
            display: inline-block;
            border-radius: 5px;
            color: #009d18;
        }
        #rotation-result .week-number{
            padding: 15px;
            background-color: #f66161;
            border-radius: 5px;
            font-weight:500;
            color: #ac0000;
        }
    </style>
    @vite('/js/schedule.js')
</head>
<body>
    <div class="container">
        <select id="schedule-select-type" onchange="swichRotationType()">
            <option value="0">Select type of schedule</option>
            <option value="whole">Whole</option>
            <option value="partial">Partial</option>
        </select>
    </div>
    <div class="container" id="container-whole">
        <table>
            <thead>
                <tr>
                    <th>Queue</th>
                    <th>Room</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 1;
                @endphp
                @if (!empty($bedrooms))
                    @foreach ($bedrooms as $row)
                    <tr>
                        <td>Week {{$i}}</td>
                        <td>
                            <select class="select-rotation-base-whole">
                                @foreach ($bedrooms as $bedroom)
                                    <option 
                                        data-unique-id="{{$bedroom->unique_id}}"
                                        data-number="{{$bedroom->number}}" 
                                        data-type="{{$bedroom->type}}" 
                                        value="{{$bedroom->unique_id}}"
                                    >
                                    bedroom number {{$bedroom->number}}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        
                    </tr>
                    @php
                    $i++;
                    @endphp
                    @endforeach
                @else
                <tr>
                    <td colspan="2">No bedrooms found</td>
                </tr>
                @endif
            </tbody>
        </table>
        <input type="date" />
        <button>Save the plan</button>
    </div>
    <div class="container" id="container-partial">
        <label>Partial schedule</label>
        <table id="partial-rotation-table-base" data-house="{{$houseID}}">
            @foreach ($rooms as $room)
                <tr>
                    <td>
                        <select class="select-rotation-base">
                            @foreach ($bedrooms as $bedroom)
                                <option 
                                    data-unique-id="{{$bedroom->unique_id}}"
                                    data-number="{{$bedroom->number}}" 
                                    data-type="{{$bedroom->type}}" 
                                    value="{{$bedroom->unique_id}}"
                                >
                                bedroom number {{$bedroom->number}}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td 
                        class="td-rotation-base" 
                        data-unique-id="{{$room->unique_id}}"
                        data-number="{{$room->number}}"
                        data-type="{{$room->type}}"
                    >
                        {{RoomTypeHelper::check($room->type)}} nr {{$room->number}}
                    </td>
                </tr>
            @endforeach
        </table>
        <button id="btn-generte-prtial-schedule" onclick="renderPlanNow()">Generate partial schedule</button>
        
        <table id="rotation-result">
        </table>
        <input id="schedule-start-date-partial" type="date" placeholder="Start date of the schedule">
        <button id="accept-and-send-schedule" style="display: none" onclick="sendPlan()">Accept & send</button>
    </div>
    <script>
        var schedule = '';
        var houseId = '';
        swichRotationType();
    
        function swichRotationType() {
            const selected = document.getElementById('schedule-select-type').value;
            const partial = document.getElementById('container-partial');
            const whole = document.getElementById('container-whole');
    
            whole.style.display = 'none';
            partial.style.display = 'none';
    
            switch (selected) {
                case 'whole':
                    whole.style.display = 'block';
                    break;
                case 'partial':
                    partial.style.display = 'block';
                    break;
                default:
                    whole.style.display = 'none';
                    partial.style.display = 'none';
            }
        }
    
        function getRotationRowsFromBaseTable() {
            const table = document.getElementById('partial-rotation-table-base'); 
            const rows = table.querySelectorAll('tbody tr'); 
            const assignments = [];
    
            rows.forEach(row => {
                const bedroomSelect = row.querySelector('.select-rotation-base');
                const bedroomOption = bedroomSelect.options[bedroomSelect.selectedIndex];
    
                const bedroomId = bedroomOption.dataset.uniqueId; 
                const bedroomNumber = bedroomOption.dataset.number;
                const bedroomType = bedroomOption.dataset.type;
    
                const tdRoom = row.querySelector('.td-rotation-base');
                const roomId = tdRoom.dataset.uniqueId;
                const roomType = tdRoom.dataset.type;
                const roomNumber = tdRoom.dataset.number;
    
                assignments.push({
                    bedroomId,
                    bedroomNumber,
                    bedroomType,
                    room: { id: roomId, type: roomType, number: roomNumber }
                });
            });
    
            return assignments;
        }
    
        function getAllBedrooms() {
            const table = document.getElementById('partial-rotation-table-base'); 
            const selects = table.querySelectorAll('.select-rotation-base');
            const bedroomsSet = new Map();
    
            selects.forEach(select => {
                Array.from(select.options).forEach(option => {
                    const id = option.dataset.uniqueId;
                    if (!bedroomsSet.has(id)) {
                        bedroomsSet.set(id, {
                            id,
                            number: option.dataset.number,
                            type: option.dataset.type
                        });
                    }
                });
            });
    
            return Array.from(bedroomsSet.values());
        }
    
        function generateRotationPlan() {
            const baseAssignments = getRotationRowsFromBaseTable();
            const allBedrooms = getAllBedrooms();
            
            const totalWeeks = allBedrooms.length;
            const plan = [];
    
            for (let w = 0; w < totalWeeks; w++) {
                const weekPlan = {};
    
                allBedrooms.forEach((bedroom, i) => {
                    const nextIndex = (i - w + allBedrooms.length) % allBedrooms.length;
                    const sourceBedroom = allBedrooms[nextIndex];
    
                    const rooms = baseAssignments
                        .filter(a => a.bedroomId === sourceBedroom.id)
                        .map(a => a.room);
    
                    weekPlan[i] = {
                        bedroom: {
                            id: bedroom.id,
                            type: bedroom.type,
                            number: bedroom.number
                        },
                        rooms: rooms.length ? rooms : [{ id: null, type: null, number: null }]
                    };
                });
    
                plan.push(weekPlan);
            }
    
            return plan;
        }
    
        function renderRotationPlan(plan) {
            const table = document.getElementById("rotation-result");
            const buttonAcceptSend = document.getElementById('accept-and-send-schedule');
            table.innerHTML = "";
    
            plan.forEach((weekPlan, weekIndex) => {
                const tr = document.createElement("tr");
    
                const tdWeek = document.createElement("td");
                tdWeek.innerHTML = '<span class="week-number">Week ' + (weekIndex + 1) + '</span>';
                tr.appendChild(tdWeek);
    
                const tdAssignments = document.createElement("td");
                tdAssignments.innerHTML = Object.values(weekPlan)
                    .map(b => {
                        const bedroomLabel = `room nr ${b.bedroom.number}`;
                        
                        return `
                        <div class="bedroom-data">
                        <span class="bedroom-span">${bedroomLabel}</span>
                        ${b.rooms.map(r => {
                            const label = r.id ? `${r.type} nr ${r.number}` : "idle";
                            if (label != 'idle')
                            {
                                return `<span class="room-labels-span">${label}</span>`;
                            }
                            else{
                                return `<span class="room-labels-span-idle">${label}</span>`;
                            }
                        }).join('')}
                        </div>`;
                    }).join('')
                tr.appendChild(tdAssignments);
    
                table.appendChild(tr);
            });
            buttonAcceptSend.style.display = 'block';
            let url = '#accept-and-send-schedule';
            window.location.href = url;
        }
    
        function renderPlanNow() {
            const plan = generateRotationPlan();
            renderRotationPlan(plan);
    
            const table = document.getElementById('partial-rotation-table-base');
            houseId = table.dataset.house;
            schedule = JSON.stringify(plan);
            const payload = {
                houseId: houseId,
                schedule: JSON.stringify(plan)
            };
            console.log(plan);
        }
        function sendPlan(){
            const type = document.getElementById('schedule-select-type').value;
            const start_date = document.getElementById('schedule-start-date-partial').value;

            const formData = {
                start_date: start_date,
                type: type,
                house: houseId,
                json: schedule
            }
            console.log(formData);
            axios.post('/api/cleaning-queue', formData)
            .then(response => {
                const msg = response.data.message;
                console.log(msg);
            })
            .catch(error => {
                if (error.response) {
                    console.log(error.response.data);    
                    if (error.response.status === 419 || error.response.status === 401) {
                        console.log(error.response.data.message);
                    }
                    if (error.response.status === 422) {
                        const errors = error.response.data.errors;
                    } else {
                        console.error(error.message);
                    }
                } else {
                    console.error(error);
                }
            });
        }
    </script>
</body>
</html>