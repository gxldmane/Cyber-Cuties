<?php

namespace App\Services;

use App\Data\CategoryData;
use App\Models\Category;
use Spatie\LaravelData\DataCollection;

class CategoryService
{
    public function getAllCategories()
    {
        return CategoryData::collect(Category::all(), DataCollection::class)->wrap('data')
            ->except('ranks');
    }

    public function getCategoryById(int $id)
    {
        $category = Category::with('ranks')->find($id);
        if (!$category) {
            return null;
        }
        return CategoryData::from($category);
    }
}
