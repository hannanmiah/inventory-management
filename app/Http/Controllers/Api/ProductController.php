<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Queries\ProductQuery;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function __construct(protected ProductQuery $productQuery)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all products
        $products = $this->productQuery->query()->paginate();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // validate and store
        $product = Product::create($request->validated());
        return $this->success(ProductResource::make($product), 'Product Created', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $product_id)
    {
        // find or fail
        $product = $this->productQuery->query()->findOrFail($product_id);
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // validate and update
        $product->update($request->validated());
        // return updated resource
        return $this->success(ProductResource::make($product), 'Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // destroy
        $product->delete();
        return $this->success([], 'Product Deleted', 204);
    }
}
