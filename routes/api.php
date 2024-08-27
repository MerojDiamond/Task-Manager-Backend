<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "auth"], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
});
Route::group(["prefix" => "user", "middleware" => "auth:sanctum"], function () {
    Route::get('/{user}', [UserController::class, 'show']);
    Route::get('/{id}/projects', [UserController::class, 'projects']);
});
Route::group(["prefix" => "projects", "middleware" => "auth:sanctum"], function () {
    Route::get('/{id}', [ProjectController::class, 'show']);
    Route::post('/', [ProjectController::class, 'create']);
    Route::put('/{project}', [ProjectController::class, 'update']);
    Route::delete('/{project}', [ProjectController::class, 'delete']);

    Route::post('/{project_id}/tasks', [ProjectController::class, 'createTask']);
    Route::put('/{project}/tasks/{task}', [ProjectController::class, 'updateTask']);
    Route::delete('/{project}/tasks/{task}', [ProjectController::class, 'deleteTask']);
});
