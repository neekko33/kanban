<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\TaskController;

Route::get('users', function (Request $request) {
    return response()->json([
        'token' => 'Hihihi!'
    ]);
});

Route::post('login', [AuthController::class, 'login']);

Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/boards', [BoardController::class, 'index']);
    Route::get('/boards/{board}', [BoardController::class, 'show']);
    Route::post('/boards', [BoardController::class, 'store']);
    Route::put('/boards/{board}', [BoardController::class, 'update']);

    Route::get('/{board}/tasks', [TaskController::class, 'index']);
    Route::get('/{board}/tasks/{task}', [TaskController::class, 'show']);
    Route::post('/{board}/tasks', [TaskController::class, 'store']);
    Route::put('/{board}/tasks/{task}', [TaskController::class, 'update']);
});
