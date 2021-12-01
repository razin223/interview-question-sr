<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantPrice extends Model {

    public function getProductVarientOne() {
        return $this->belongsTo('App\Models\ProductVariant', 'product_variant_one', 'id');
    }

    public function getProductVarientTwo() {
        return $this->belongsTo('App\Models\ProductVariant', 'product_variant_two', 'id');
    }

    public function getProductVarientThree() {
        return $this->belongsTo('App\Models\ProductVariant', 'product_variant_three', 'id');
    }

    public function getProduct() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

}
