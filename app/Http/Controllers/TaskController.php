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
        
        // Pengecekan: Jika daftar tasks kosong
        if ($tasks->isEmpty()) {
            return response()->json([
                'message' => 'Data task kosong. Silakan tambahkan task baru.'
            ], 200); // Menggunakan 200 OK karena permintaan berhasil
        }

        return response()->json($tasks);
    }

    // CREATE
    public function store(Request $request)
    {
        // 1. Validasi Data
        $taskData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'is_completed' => 'boolean'
        ]);

        // 2. Simpan Data
        $task = TaskModel::create($taskData);

        // 3. Respon
        return response()->json([
            'message' => 'Task created successfully!',
            'data' => $task
        ], 201); // 201 Created
    }

    // READ (Data tunggal)
    public function show($id)
    {
        // Menggunakan findOrFail untuk otomatis melempar 404 jika data tidak ditemukan
        try {
            $task = TaskModel::findOrFail($id);
            return response()->json($task);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data task tidak ditemukan.'
            ], 404); // 404 Not Found
        }
    }

    // UPDATE
    public function update(Request $request, string $id)
    {
        // Cari data. Jika tidak ada, kembalikan 404 Not Found.
        $task = TaskModel::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Gagal update. Data task tidak ditemukan.'
            ], 404);
        }

        // 1. Validasi Data
        $validatedData = $request->validate([
            'title' => 'sometimes|required|max:255', // Gunakan 'sometimes' agar tidak wajib di setiap request PATCH/PUT
            'description' => 'nullable',
            'is_completed' => 'sometimes|boolean'
        ]);

        // 2. Perbarui Data
        $task->update($validatedData);

        // 3. Respon
        return response()->json([
            'message' => 'Task updated successfully!',
            'data' => $task
        ], 200);
    }

    // DELETE
    public function destroy(string $id)
    {
        // Cari data. Jika tidak ada, kembalikan 404 Not Found.
        $task = TaskModel::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Gagal hapus. Data task tidak ditemukan.'
            ], 404);
        }

        $task->delete();
        
        // Respon
        return response()->json([
            'message' => 'Task deleted successfully!'
        ], 200); 
    }
}