<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function createTask (Request $request){
        try {
            $validated = $request->validate([
                'user_id'   => 'required|exists:users,id',
                'title'     => 'required|string|max:255',
                'description' => 'max:255',
                'category'  => 'required|string|max:100',
                'priority'  => 'required|string|max:50',
                'status'    => 'required|string|max:50',
                'date'      => 'required|date',
            ]);

            $existingTask = Task::where('title', $validated['title'])
                ->where('user_id', $validated['user_id'])
                ->first();

            if ($existingTask) {
                return response()->json(['message' => 'Task already exists!'], 400);
            }

            $task = Task::create($validated);

            return response()->json(['message' => 'Task added successfully!', 'task' => $task], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function getTasks (Request $request){
        try {
            $tasks = Task::get();
            return response()->json(['message' => 'Tasks fetched successfully!', 'data' => $tasks], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function deleteTask($id) {
        try {
            $existingTask = Task::find($id);
    
            if ($existingTask) {
                $existingTask->delete();
                return response()->json(['message' => 'Task deleted successfully!'], 200);
            } else {
                return response()->json(['message' => 'Task not found!'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function updateTask (Request $request, $id){
        try {
            $existingTask = Task::find($id);
    
            if (!$existingTask) {
                return response()->json(['message' => 'Task could not be found!'], 404);
            }

            $existingTask->update($request->only([
                'title', 'description' ,'category', 'status', 'priority', 'date'
            ]));
    
            return response()->json(['message' => 'Task updated successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    
    public function markTaskAsCompleted ($id){
        try {
            $existingTask = Task::find($id);
    
            if (!$existingTask) {
                return response()->json(['message' => 'Task could not be found!'], 404);
            }

            $existingTask->status = 'Completed';
            $existingTask->save();
    
            return response()->json(['message' => 'Task updated successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
