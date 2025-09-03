@php
use App\Helpers\RoomTypeHelper;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create house</title>
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
        <label>House Name</label>
        <input id="input-house-name">
        <label>House address</label>
        <input id="input-house-address">
        <button id="button-create-house">create house</button>
    </div>
</body>
</html>