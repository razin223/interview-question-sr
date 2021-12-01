<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request) {
        $Product = Product::with(
                        'getProductVariantPrice.getProductVarientOne',
                        'getProductVariantPrice.getProductVarientTwo',
                        'getProductVariantPrice.getProductVarientThree'
        );
        if (!empty($request->title)) {
            $Product = $Product->where('title', 'like', '%' . $request->title . "%");
        }
        if (!empty($request->variant)) {
            $Product = $Product->where(function($query)use($request) {
                $query->whereHas('getProductVariantPrice.getProductVarientOne', function($query1)use ($request) {
                    $query1->where('product_variants.variant', $request->variant);
                })->orWhereHas('getProductVariantPrice.getProductVarientTwo', function($query1)use ($request) {
                    $query1->where('product_variants.variant', $request->variant);
                })->orWhereHas('getProductVariantPrice.getProductVarientThree', function($query1)use ($request) {
                    $query1->where('product_variants.variant', $request->variant);
                });
            });
        }

        if (!empty($request->price_from)) {
            $Product = $Product->whereHas('getProductVariantPrice', function($query)use ($request) {
                $query->where('product_variant_prices.price', '>=', $request->price_from);
            });
        }

        if (!empty($request->price_to)) {
            $Product = $Product->whereHas('getProductVariantPrice', function($query)use ($request) {
                $query->where('product_variant_prices.price', '<=', $request->price_to);
            });
        }
        if (!empty($request->title)) {
            $Product = $Product->where('title', 'like', '%' . $request->title . "%");
        }
        if (!empty($request->title)) {
            $Product = $Product->where('title', 'like', '%' . $request->title . "%");
        }
        $Product = $Product->paginate(5)->withQueryString();



        return view('products.index', compact('Product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create() {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $Product = new Product;
        $Product->title = $request->title;
        $Product->sku = $request->sku;
        $Product->description = $request->description;
        $Product->save();
        
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        //
    }

}
