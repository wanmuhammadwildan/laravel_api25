<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    // GET: Mengambil semua data
   // READ (Semua data)
   public function index()
   {
       $categories = ProductCategory::all();
       
       // Pengecekan: Jika daftar tasks kosong
       if ($categories->isEmpty()) {
           return response()->json([
               'message' => 'Data category kosong. Silakan tambahkan category baru.'
           ], 200); // Menggunakan 200 OK karena permintaan berhasil
       }

       return response()->json($categories);
   }

   // CREATE
   public function store(Request $request)
   {
       // 1. Validasi Data
       $categoryData = $request->validate([
           'name' => 'required|max:255',
           'description' => 'nullable',
       ]);

       // 2. Simpan Data
       $category = ProductCategory::create($categoryData);

       // 3. Respon
       return response()->json([
           'message' => 'Category created successfully!',
           'data' => $category
       ], 201); // 201 Created
   }

   // READ (Data tunggal)
   public function show($id)
   {
       // Menggunakan findOrFail untuk otomatis melempar 404 jika data tidak ditemukan
       try {
           $category = ProductCategory::findOrFail($id);
           return response()->json($category);
       } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
           return response()->json([
               'message' => 'Data category tidak ditemukan.'
           ], 404); // 404 Not Found
       }
   }

   // UPDATE
   public function update(Request $request, string $id)
   {
       // Cari data. Jika tidak ada, kembalikan 404 Not Found.
       $category = ProductCategory::find($id);
       if (!$category) {
           return response()->json([
               'message' => 'Gagal update. Data category tidak ditemukan.'
           ], 404);
       }

       // 1. Validasi Data
       $validatedData = $request->validate([
           'title' => 'sometimes|required|max:255', // Gunakan 'sometimes' agar tidak wajib di setiap request PATCH/PUT
           'description' => 'nullable',
           'is_completed' => 'sometimes|boolean'
       ]);

       // 2. Perbarui Data
       $category->update($validatedData);

       // 3. Respon
       return response()->json([
            'message' => 'Category updated successfully!',
           'data' => $category
       ], 200);
   }

   // DELETE
   public function destroy(string $id)
   {
       // Cari data. Jika tidak ada, kembalikan 404 Not Found.
       $category = ProductCategory::find($id);
       if (!$category) {
           return response()->json([
               'message' => 'Gagal hapus. Data category tidak ditemukan.'
           ], 404);
       }

       $category->delete();
       
       // Respon
       return response()->json([
           'message' => 'Category deleted successfully!'
       ], 200); 
   }
}