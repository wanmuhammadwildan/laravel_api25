<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Tambahkan 'product_category_id' di sini untuk mengizinkan mass assignment.
        'name',
        'code',
        'product_category_id', // FIX: Kolom ini ditambahkan
    ];

    /**
     * Get the category that owns the Product.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        // Menentukan foreign key secara eksplisit, yang merupakan praktik yang baik.
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    /**
     * Get the variants for the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        // Mengasumsikan model ProductVariant ada.
        return $this->hasMany(ProductVariant::class);
    }
}