<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', 'user');
        Route::post('/logout', 'logout');
        Route::post('/logout-all', 'logoutAll');
        Route::get('/tokens', 'tokens');
    });
});


Route::apiResource('vehicles', VehicleController::class)->middleware('auth:sanctum');

Route::post('/write-txt', function (Request $request) {
    Storage::disk('public')->put('example.txt', $request->text);
    return response()->json([
        "message" => "example.txt saved successfully"
    ]);
});
