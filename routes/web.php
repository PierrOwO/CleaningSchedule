
<?php

use App\Controllers\ScheduleController;
use App\Middleware\Authenticate;
use Support\Vault\Routing\Route;

/**
 * File: routes/web.php
 *
 * This file is used to define the application routes handled by your custom Route class.
 * Each route maps a specific URL path to the logic that should be executed when that path is visited,
 * such as rendering a view, calling a controller method, or processing form data.
 *
 * Example usage:
 * Route::get('/home', function () {
 *     return view('home');
 * });
 *
 * Common methods (depending on your implementation):
 * - Route::get($path, $action)     – registers a GET route
 * - Route::post($path, $action)    – registers a POST route
 *
 * In this file, you can:
 * - Define simple routes using closures
 * - Map URLs to controller methods
 * - Use dynamic URL segments (e.g. '/orders/{id}')
 *
 * This is the central place for managing how URLs map to your application's functionality.
 */

 Route::get('/schedule', [ScheduleController::class, 'index']);
 Route::get('/schedule/tenants', [ScheduleController::class, 'addTenant']);
 Route::get('/schedule/tenants/{house}', [ScheduleController::class, 'addTenant']);
 Route::get('/schedule/{house}/make-plan', [ScheduleController::class, 'makePlan']);
 Route::get('/schedule/{house}/show-plan', [ScheduleController::class, 'showSchedule']);

Route::middleware([Authenticate::class], function () {
   Route::get('/', [ScheduleController::class, 'viewDashboard']);
   Route::get('/create-house', [ScheduleController::class, 'viewCreateHouse']);
   Route::get('/add-rooms-to-houses', [ScheduleController::class, 'viewCreateRooms']);
   Route::get('/{house}/make-plan', [ScheduleController::class, 'viewMakePlan']);
   
});
 Route::get('/plan/{slug}', [ScheduleController::class, 'scheduleBySlug']);