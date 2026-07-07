<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Middleware\JwtToken;



use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/profile', [AuthController::class, 'profile']);
});
Route::middleware(['throttle:60,1', JwtToken::class])->group(function () {
    Route::apiResource('medicines', MedicineController::class)->parameters([
        'medicines' => 'slug' // This maps {medicine} in the route to {slug} parameter in the controller
    ]);
});
