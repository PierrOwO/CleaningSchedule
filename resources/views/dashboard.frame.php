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
</head>
<body>
<main>
    <a class="logout" href="logout">Logout</a>
    <div class="main">
      <h1>Hello there!</h1>
      <h4>Your Name is {{ auth()->user()->name}}</h4>
    </div>
    <div class="main">
      <h1>Today is {{ DateHelper::nowFormated() }}, week {{ DateHelper::getCurrentWeekNumber() }}.</h1>
      <h2>This week, it’s room {{ DateHelper::thisWeekSchelude() }}’s turn to clean the apartment.</h2>
    </div>
    <div class="main">
      <h2>Next week, it will be room {{ DateHelper::nextWeekSchelude() }}’s turn to clean the apartment.</h2>
    </div>
    <div class="main">
      <h2>Last week, it was room {{ DateHelper::previousWeekSchelude() }}’s turn to clean the apartment.</h2>
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
</body>
</html>
