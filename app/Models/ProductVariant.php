<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model {

    public function getProduct() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function getVariant() {
        return $this->belongsTo('App\Models\Variant', 'varient_id', 'id');
    }

}
