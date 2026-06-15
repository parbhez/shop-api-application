<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Middleware\VerifyStaticToken;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['throttle:60,1', VerifyStaticToken::class])->group(function () {
    Route::apiResource('medicines', MedicineController::class)->parameters([
        'medicines' => 'slug' // This maps {medicine} in the route to {slug} parameter in the controller
    ]);
});
