<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $fillable = [
        'title', 'sku', 'description'
    ];

    public function getProductVarient() {
        return $this->hasMany('App\Models\ProductVariant', 'product_id', 'id');
    }
    
    public function getProductImage() {
        return $this->hasMany('App\Models\ProductImage', 'product_id', 'id');
    }
    
    public function getProductVariantPrice() {
        return $this->hasMany('App\Models\ProductVariantPrice', 'product_id', 'id');
    }

}
