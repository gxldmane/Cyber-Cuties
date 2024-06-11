<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        return CategoryResource::collection(Category::query());
    }

    public function getCategoryById(int $id)
    {
        $category = Category::with('ranks')->find($id);
        if (!$category) {
            return null;
        }
        return new CategoryResource($category);
    }
}
