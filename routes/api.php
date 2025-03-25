<?php

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/users/sign-up',[UserController::class,'signUp']);

Route::post('/users/sign-in',[UserController::class,'signIn']);

Route::post('/tasks/create-task',[TaskController::class,'createTask']);

Route::get('/tasks/',[TaskController::class,'getTasks']);

Route::delete('/tasks/delete-task/{id}', [TaskController::class, 'deleteTask']);

Route::put('/tasks/update-task/{id}', [TaskController::class, 'updateTask']);

Route::put('/tasks/update-task-status/{id}', [TaskController::class, 'markTaskAsCompleted']);