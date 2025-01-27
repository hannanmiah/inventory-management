<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Queries\ProductQuery;
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
        $categories = Category::select('id', 'name')->get();
        // get all products
        $products = $this->productQuery->query()->with('category')->get();
        return Inertia::render('Product/Index', ['products' => ProductResource::collection($products),'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        // return create page
        return Inertia::render('Product/Create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // validate and store
        Product::create($request->validated());
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // load category
        $product->load('category');
        // return show page
        return Inertia::render('Product/Show', ['product' => ProductResource::make($product)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        // return edit page
        return Inertia::render('Product/Edit', ['product' => ProductResource::make($product), 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // validate and update
        $product->update($request->validated());
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // destroy
        $product->delete();
        return redirect()->route('products.index');
    }
}
