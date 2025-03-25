<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tasks/create-task',[TaskController::class,'createTask']);

Route::get('/tasks/',[TaskController::class,'getTasks']);

Route::delete('/tasks/delete-task/{id}', [TaskController::class, 'deleteTask']);

Route::put('/tasks/update-task/{id}', [TaskController::class, 'updateTask']);

Route::put('/tasks/update-task-status/{id}', [TaskController::class, 'markTaskAsCompleted']);