<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource (index).
     * Mengambil semua varian produk dan mengembalikannya.
     */
    public function index()
    {
        // Ambil semua varian produk.
        $variants = ProductVariant::all();

        // Kembalikan dalam format JSON.
        return response()->json($variants);
    }

    /**
     * Store a newly created resource in storage (store).
     * Menyimpan varian produk baru ke database.
     */
    public function store(Request $request)
    {
        try {
            // 1. Validasi Data
            $validatedData = $request->validate([
                // Memperbaiki sintaks validasi: menambahkan koma dan memperbaiki 'exists'
                'product_id'       => 'required|integer|exists:products,id', // Harus ada di tabel products
                'variant_name'     => 'required|string|max:255',
                'additional_price' => 'required|numeric|min:0',
                'stock'            => 'required|integer|min:0',
            ]);

            // 2. Buat Data
            $productVariant = ProductVariant::create($validatedData);

            // 3. Respon Sukses (201 Created)
            return response()->json([
                'message' => 'Varian produk berhasil dibuat!',
                'data' => $productVariant
            ], 201);

        } catch (ValidationException $e) {
            // Tangani kegagalan validasi
            return response()->json([
                'message' => 'Data validasi tidak valid.',
                'errors' => $e->errors()
            ], 422); // 422 Unprocessable Entity
        }
    }

    /**
     * Display the specified resource (show).
     * Mengambil data varian produk tunggal berdasarkan ID.
     */
    public function show($id)
    {
        // Menggunakan findOrFail untuk otomatis melempar 404 jika data tidak ditemukan
        try {
            $productVariant = ProductVariant::with('product')->findOrFail($id);
            return response()->json($productVariant);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data varian produk tidak ditemukan.'
            ], 404); // 404 Not Found
        }
    }

    /**
     * Update the specified resource in storage (update).
     * Memperbarui data varian produk yang ada.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Cari data. Jika tidak ada, findOrFail akan melempar pengecualian.
            $productVariant = ProductVariant::findOrFail($id);

            // 1. Validasi Data (Menggunakan 'sometimes' untuk PATCH/PUT)
            $validatedData = $request->validate([
                'product_id'       => 'sometimes|required|integer|exists:products,id',
                'variant_name'     => 'sometimes|required|string|max:255',
                'additional_price' => 'sometimes|required|numeric|min:0',
                'stock'            => 'sometimes|required|integer|min:0',
            ]);

            // 2. Perbarui Data
            $productVariant->update($validatedData);

            // 3. Respon Sukses (200 OK)
            return response()->json([
                'message' => 'Varian produk berhasil diperbarui!',
                'data' => $productVariant
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Gagal update. Data varian produk tidak ditemukan.'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Data validasi tidak valid.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage (destroy).
     * Menghapus varian produk dari database.
     */
    public function destroy(string $id)
    {
        try {
            // Cari data. Jika tidak ada, findOrFail akan melempar pengecualian.
            $productVariant = ProductVariant::findOrFail($id);
            
            $productVariant->delete();
            
            // Respon Sukses (200 OK)
            return response()->json([
                'message' => 'Varian produk berhasil dihapus!'
            ], 200); 

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Gagal hapus. Data varian produk tidak ditemukan.'
            ], 404);
        }
    }
}