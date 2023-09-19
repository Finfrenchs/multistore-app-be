<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Product::all(); //this get all product
        // return Product::paginate(10); //this function will get 10 product list
        return ProductResource::collection(Product::paginate(10)); //customize with resource
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::create([
            ...$request->validate([
                'name' => 'required|string|max:100',
                'description' => 'required|string',
                'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'image_url' => 'required',
                'category_id' => 'required',
            ]),
            'user_id' => 1,
        ]);

        return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category', 'user'); //use load() because for know this product on the category and user spesifik
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update(
            $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'image_url' => 'required',
            'category_id' => 'required',
        ]));

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response(status:204);
    }
}
