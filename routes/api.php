<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [HomeController::class, 'me']);

    Route::get('/boards/latest', [BoardController::class, 'latest']);
    Route::put('/boards/{board}', [BoardController::class, 'update']);

    Route::post('/{board}/tasks', [TaskController::class, 'store']);
    Route::put('/{board}/tasks/{task}', [TaskController::class, 'update']);
});
