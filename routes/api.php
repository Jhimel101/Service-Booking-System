<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {

    // Services
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{service}', [ServiceController::class, 'show']);

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);

    // Admin routes
    Route::middleware('can:admin')->prefix('admin')->group(function () {
        Route::post('/services', [AdminController::class, 'createService']);
        Route::put('/services/{service}', [AdminController::class, 'updateService']);
        Route::delete('/services/{service}', [AdminController::class, 'deleteService']);
        Route::get('/bookings', [AdminController::class, 'getAllBookings']);
    });
});
