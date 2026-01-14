<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data to avoid duplicates
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductVariant::truncate();
        Product::truncate();
        ProductCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Categories
        $electronics = ProductCategory::create([
            'name' => 'Electronics',
            'description' => 'Gadgets, devices, and accessories'
        ]);

        $furniture = ProductCategory::create([
            'name' => 'Furniture',
            'description' => 'Home and office furniture'
        ]);

        $clothing = ProductCategory::create([
            'name' => 'Clothing',
            'description' => 'Men and women apparel'
        ]);

        // Create Products for Electronics
        $laptop = Product::create([
            'name' => 'Gaming Laptop',
            'code' => 'LAP-001',
            'product_category_id' => $electronics->id
        ]);

        ProductVariant::create([
            'product_id' => $laptop->id,
            'variant_name' => '16GB RAM / 512GB SSD',
            'additional_price' => 0,
            'stock' => 10
        ]);

        ProductVariant::create([
            'product_id' => $laptop->id,
            'variant_name' => '32GB RAM / 1TB SSD',
            'additional_price' => 200,
            'stock' => 5
        ]);

        $phone = Product::create([
            'name' => 'Smartphone X',
            'code' => 'PHN-001',
            'product_category_id' => $electronics->id
        ]);

        ProductVariant::create([
            'product_id' => $phone->id,
            'variant_name' => 'Black',
            'additional_price' => 0,
            'stock' => 25
        ]);

        ProductVariant::create([
            'product_id' => $phone->id,
            'variant_name' => 'Gold',
            'additional_price' => 50,
            'stock' => 15
        ]);

        // Create Products for Furniture
        $chair = Product::create([
            'name' => 'Ergonomic Chair',
            'code' => 'CHR-001',
            'product_category_id' => $furniture->id
        ]);

        ProductVariant::create([
            'product_id' => $chair->id,
            'variant_name' => 'Mesh Black',
            'additional_price' => 0,
            'stock' => 30
        ]);

        // Create Products for Clothing
        $tshirt = Product::create([
            'name' => 'Cotton T-Shirt',
            'code' => 'TSH-001',
            'product_category_id' => $clothing->id
        ]);

        ProductVariant::create([
            'product_id' => $tshirt->id,
            'variant_name' => 'Small',
            'stock' => 100
        ]);

        ProductVariant::create([
            'product_id' => $tshirt->id,
            'variant_name' => 'Medium',
            'stock' => 150
        ]);

        ProductVariant::create([
            'product_id' => $tshirt->id,
            'variant_name' => 'Large',
            'stock' => 80
        ]);

        $fnb = ProductCategory::create([
            'name' => 'Food & Beverage',
            'description' => 'Delicious food and drinks'
        ]);

        $coffee = Product::create([
            'name' => 'Specialty Coffee',
            'code' => 'CFE-001',
            'product_category_id' => $fnb->id
        ]);

        ProductVariant::create([
            'product_id' => $coffee->id,
            'variant_name' => 'Light Roast (250g)',
            'additional_price' => 5,
            'stock' => 50
        ]);

        ProductVariant::create([
            'product_id' => $coffee->id,
            'variant_name' => 'Medium Roast (250g)',
            'additional_price' => 5,
            'stock' => 50
        ]);

        ProductVariant::create([
            'product_id' => $coffee->id,
            'variant_name' => 'Dark Roast (250g)',
            'additional_price' => 5,
            'stock' => 50
        ]);
    }
}
