<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;

Route::post("/login", [AuthController::class, "login"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/me", [HomeController::class, "me"]);

    Route::get("/boards/latest", [BoardController::class, "latest"]);
    Route::post("/boards", [BoardController::class, "store"]);
    Route::put("/boards/{board}", [BoardController::class, "update"]);

    Route::get("/{board}/tasks/{task}", [TaskController::class, "show"]);
    Route::post("/{board}/tasks", [TaskController::class, "store"]);
    Route::put("/{board}/tasks/{task}", [TaskController::class, "update"]);

    Route::get("/posts", [PostController::class, "index"]);

    Route::get("/categories", [CategoryController::class, "index"]);

    Route::get("/tags", [TagController::class, "index"]);
});
