<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();

        return Inertia::render('ExpenseCategories', [
            "categories" => $categories
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route(route: 'categories')->with('message', 'New category created successfully.');
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $category->update($request->validated());
        return redirect()->route(route: 'categories')->with('message', 'A category was updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route(route: 'categories')->with('message', 'A category was deleted successfully.');
    }

}
