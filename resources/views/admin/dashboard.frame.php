@php 
use App\Helpers\DateHelper;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="description" content="QuickFrame is a simple, lightweight PHP framework featuring routing, controllers, sessions, and Blade-like views. Perfect for small projects and learning." />
    <meta name="keywords" content="QuickFrame, PHP framework, routing, sessions, custom framework, lightweight framework" />
    <meta name="author" content="Piotr Miłoś" />
    
    @vite('js/app.js')
    @vite('js/modal.js')
</head>
<body>
<main>
    <a class="logout" href="logout">Logout</a>
    <div class="main">
      <h1>Hello founder!</h1>
      <h4>Your name is {{ auth()->user()->name}}</h4>
    </div>
    <div class="main">
      <h1>Today is {{ DateHelper::nowFormated() }}, week {{ DateHelper::getCurrentWeekNumber() }}.</h1>
      <h2>You have created a total of {{$totalHouses}} houses, list below:</h2>
    @if (!empty($houses))
        @foreach ($houses as $row)
        <h3>{{$row->name}}, address: {{$row->address}} 
            <button onclick="makePlan('{{$row->name}}','{{$row->id}}')">make plan</button>
            <button onclick="showPlan('{{$row->name}}','{{$row->id}}')">show plan</button>
        </h3>
        @endforeach
    @else
        <h3>No houses found</h3>

    @endif
    </div>
    <div class="btn-container">
        <button class="btn-main" onclick="createNewHouse()">Create a new House</button>
        <button class="btn-main" onclick="addRoomsToHouses()">Add rooms to the Houses</button>
        <button class="btn-main" onclick="addTenantsToRooms()">Add tenants to the rooms</button>
      </div>
    <div class="main">
      <h2>You're a tenant in house 'House 3, address' </h2>
    </div>
    <div class="btn-container">
      <button class="btn-main">Check the cleaning schedule</button>
    </div>
</main>
<footer class="footer">
  <div class="container">
    <p>&copy; 2025 QuickFrame v{{config('app.version')}} by PierrOwO. MIT License. <a href="https://github.com/PierrOwO/quickframe">GitHub</a></p>
  </div>
</footer>
<script>
    function createNewHouse(){
        let url = '/create-house';
            window.location.href = url;
    }
    function addRoomsToHouses(){
        let url = '/add-rooms-to-houses';
            window.location.href = url;
    }
    function addTenantsToRooms(){
        let url = '/add-tenants-to-rooms';
            window.location.href = url;
    } 
    function makePlan(name, id){
        let url = '/' + name + '-' + id + '/make-plan';
            window.location.href = url;
    } 
</script>
</body>
</html>
