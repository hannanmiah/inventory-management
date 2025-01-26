<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Queries\CategoryQuery;
use Illuminate\Http\Request;
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
        $categories = $this->query->query()->withCount('products')->paginate();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // validate and store
        $category = Category::create($request->validated());
        return $this->success(CategoryResource::make($category), 'Category Created', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $category_id): CategoryResource
    {
        // find category
        $category = $this->query->query()->findOrFail($category_id);
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // validate and update
        $category->update($request->validated());
        return $this->success(CategoryResource::make($category), 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // destroy
        $category->delete();
        return $this->success([], 'Category Deleted', 204);
    }
}
