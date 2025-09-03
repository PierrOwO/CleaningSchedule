<?php

use App\Controllers\Api\CleaningOverridesController;
use App\Controllers\Api\CleaningQueueController;
use App\Controllers\Api\HouseController;
use App\Controllers\Api\ReportController;
use App\Controllers\Api\RoomController;
use App\Controllers\Api\TenantController;
use Support\Vault\Routing\Route;
use Support\Vault\Sanctum\Log;

/**
 * File: routes/api.php
 *
 * This file is intended for defining API routes for your application.
 * These routes are typically stateless and return JSON responses,
 * making them ideal for AJAX requests, mobile apps, or frontend frameworks.
 *
 * Example usage:
 * Route::get('/api/products', [ProductController::class, 'index']);
 *
 * In this file, you can:
 * - Define RESTful API endpoints
 * - Handle data exchange in JSON format
 * - Separate web routes from programmatic API access
 *
 * API routes can be prefixed (e.g. '/api') and may have middleware like authentication or rate limiting.
 */

Route::prefix('api', function () {
    Route::prefix('house', function () {
        Route::get('/', [HouseController::class, 'index']);
        Route::post('/', [HouseController::class, 'store']);
        Route::get('/{id}', [HouseController::class, 'show']);
        Route::put('/{id}', [HouseController::class, 'update']);
        Route::delete('/{id}', [HouseController::class, 'destroy']);
    });
    Route::prefix('room', function () {
        Route::get('/', [RoomController::class, 'index']);
        Route::post('/', [RoomController::class, 'store']);
        Route::get('/{id}', [RoomController::class, 'show']);
        Route::put('/{id}', [RoomController::class, 'update']);
        Route::delete('/{id}', [RoomController::class, 'destroy']);
    });
    Route::prefix('tenant', function () {
        Route::get('/', [TenantController::class, 'index']);
        Route::post('/', [TenantController::class, 'store']);
        Route::get('/{id}', [TenantController::class, 'show']);
        Route::put('/{id}', [TenantController::class, 'update']);
        Route::delete('/{id}', [TenantController::class, 'destroy']);
    });
    Route::prefix('report', function () {
        Route::get('/', [ReportController::class, 'index']);
        Route::post('/', [ReportController::class, 'store']);
        Route::get('/{id}', [ReportController::class, 'show']);
        Route::put('/{id}', [ReportController::class, 'update']);
        Route::delete('/{id}', [ReportController::class, 'destroy']);
    });
    Route::prefix('cleaning-overrides', function () {
        Route::get('/', [CleaningOverridesController::class, 'index']);
        Route::post('/', [CleaningOverridesController::class, 'store']);
        Route::get('/{id}', [CleaningOverridesController::class, 'show']);
        Route::put('/{id}', [CleaningOverridesController::class, 'update']);
        Route::delete('/{id}', [CleaningOverridesController::class, 'destroy']);
    });
    Route::prefix('cleaning-queue', function () {
        Route::get('/', [CleaningQueueController::class, 'index']);
        Route::post('/', [CleaningQueueController::class, 'store']);
        Route::get('/{id}', [CleaningQueueController::class, 'show']);
        Route::put('/{id}', [CleaningQueueController::class, 'update']);
        Route::delete('/{id}', [CleaningQueueController::class, 'destroy']);
    });
});
Route::get('/get/bedrooms/by/house/{}', [RoomController::class, 'getBedroomsByHouse']);