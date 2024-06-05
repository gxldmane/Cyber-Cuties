<?php

namespace App\Services;

use App\Data\CategoryData;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CategoryService
{
    public function getAllCategories()
    {
        return CategoryData::collect(Category::all());
    }

    public function getCategoryById(int $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return null;
        }
        return CategoryData::from($category);
    }
}
