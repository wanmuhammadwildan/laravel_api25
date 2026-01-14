<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $productCategories = ProductCategory::with('products')->get();

            return response()->json([
                'data' => $productCategories,
            ], 200);
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required|max:255|unique:product_categories,name',
                'description' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $productCategory = ProductCategory::create($validatedData);

            DB::commit();
            return response()->json([
                'message' => 'Product category created successfully.',
                'data' => $productCategory,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['message' => $e->errors()], 422);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $productCategory = ProductCategory::findOrFail($id);

            return response()->json([
                'data' => $productCategory,
            ], 200);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Product category not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $productCategory = ProductCategory::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|max:255|unique:product_categories,name,' . $id,
                'description' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $productCategory->update($validatedData);

            DB::commit();
            return response()->json([
                'message' => 'Product category updated successfully.',
                'data' => $productCategory,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['message' => $e->errors()], 422);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $productCategory = ProductCategory::findOrFail($id);

            DB::beginTransaction();
            $productCategory->delete();
            DB::commit();

            return response()->json([
                'message' => 'Product category deleted successfully.',
                'data' => null,
            ], 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}