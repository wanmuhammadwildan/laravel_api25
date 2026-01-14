<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    // READ ALL (GET /api/products)
    public function index()
    {
        // Mengambil semua produk dengan relasi kategorinya
        $products = Product::with('category')->get();

        // Mengembalikan data sebagai JSON (Status 200 OK)
        return response()->json([
            'data' => $products
        ], 200);
    }

    // CREATE (POST /api/products)
    public function store(Request $request)
    {
        try {
            // Validasi data input
            $validatedData = $request->validate([
                // Pastikan product_category_id ada di tabel product_categories, kolom id
                'product_category_id' => 'required|exists:product_categories,id',
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:products,code', // Menambahkan validasi unique
                // Tambahkan field lain seperti price, description, dll. jika ada di tabel
            ]);

            // Membuat produk baru
            $product = Product::create($validatedData);

            // Mengembalikan respon sukses (Status 201 Created)
            return response()->json([
                'message' => 'Produk berhasil ditambahkan.',
                'data' => $product
            ], 201);

        } catch (ValidationException $e) {
            // Mengembalikan error validasi (Status 422 Unprocessable Entity)
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // READ SINGLE (GET /api/products/{id})
    public function show($id)
    {
        // Menggunakan findOrFail untuk otomatis melempar 404 jika data tidak ditemukan
        $product = Product::with('category', 'variants')->findOrFail($id);

        return response()->json([
            'message' => 'Detail produk berhasil dimuat.',
            'data' => $product
        ], 200);
    }

    // UPDATE (PUT/PATCH /api/products/{id})
    public function update(Request $request, string $id)
    {
        // Cari data. findOrFail akan melempar 404 jika data tidak ditemukan.
        $product = Product::findOrFail($id);

        try {
            // 1. Validasi Data
            $validatedData = $request->validate([
                'product_category_id' => 'sometimes|required|exists:product_categories,id',
                'name' => 'sometimes|required|string|max:255',
                'code' => 'sometimes|required|string|max:255|unique:products,code,' . $id, // Unique kecuali ID ini
                // Sesuaikan field validasi di sini
            ]);

            // 2. Perbarui Data
            $product->update($validatedData);

            // 3. Respon
            return response()->json([
                'message' => 'Produk berhasil diperbarui!',
                'data' => $product
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // DELETE (DELETE /api/products/{id})
    public function destroy(string $id)
    {
        // Cari data. findOrFail akan melempar 404 jika data tidak ditemukan.
        $product = Product::findOrFail($id);

        $product->delete();

        // Respon
        return response()->json([
            'message' => 'Produk berhasil dihapus!'
        ], 200);
    }
}