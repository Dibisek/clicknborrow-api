<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCategoryRequest;
use App\Http\Requests\V1\UpdateCategoryRequest;
use App\Models\Category;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\CategoryCollection;
use Illuminate\Http\Request;
use App\Filters\V1\CategoryFilter;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CategoryFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']])

        $includeBooks = $request->query('includeBooks');

        $category = Category::where($filterItems);

        if ($includeBooks) {
            $category = $category->with('books');
        }

        return new CategoryCollection($category->paginate()->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $includeBooks = request()->query('includeBooks');

        if ($includeBooks) {
            return new CategoryResource($category->loadMissing('books'));
        }
        return new CategoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
