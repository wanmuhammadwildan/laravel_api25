<?php

namespace App\Http\Controllers;

use App\Models\TaskModel;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // READ (Semua data)
    public function index()
    {
        $tasks = TaskModel::all();
        return response()->json($tasks);
    }

    // CREATE
    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'is_completed' => 'boolean'
        ]);

        // 2. Simpan Data
        $task = TaskModel::create($request->all());

        // 3. Respon
        return response()->json([
            'message' => 'Task created successfully!',
            'data' => $task
        ], 201); // 201 Created
    }

    // READ (Data tunggal)
    public function show(TaskModel $task)
    {
        return response()->json($task);
    }

    // UPDATE
    public function update(Request $request, TaskModel $task)
    {
        // 1. Validasi Data
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'is_completed' => 'boolean'
        ]);

        // 2. Perbarui Data
        $task->update($request->all());

        // 3. Respon
        return response()->json([
            'message' => 'Task updated successfully!',
            'data' => $task
        ]);
    }

    // DELETE
    public function destroy(TaskModel $task)
    {
        $task->delete();
        
        // Respon
        return response()->json([
            'message' => 'Task deleted successfully!'
        ], 204); // 204 No Content
    }
}