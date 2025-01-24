<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Queries\CategoryQuery;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function __construct(protected CategoryQuery $query)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all categories
        $categories = $this->query->query()->withCount('products')->get();
        return Inertia::render('Category/Index', ['categories' => CategoryResource::collection($categories)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return create view
        return Inertia::render('Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // validate and store
        Category::create($request->validated());
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia::render('Category/Edit', ['category' => CategoryResource::make($category)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // validate and update
        $category->update($request->validated());
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // destroy
        $category->delete();
        return redirect()->route('categories.index');
    }
}
