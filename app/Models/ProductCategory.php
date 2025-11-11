<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = ['name', 'code', 'description'];
    public function products() {
        return $this->hasMany(Product::class);
    }
}
