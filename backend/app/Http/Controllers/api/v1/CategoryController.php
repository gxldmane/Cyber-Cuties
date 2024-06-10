<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Symfony\Component\HttpFoundation\Response as Response;

class CategoryController extends Controller
{
    public CategoryService $service;
    public function __construct(CategoryService $categoryService)
    {
        $this->service = $categoryService;
    }

    public function index()
    {
        return $this->service->getAllCategories();
    }

    public function show(int $id)
    {
        $category = $this->service->getCategoryById($id);

        if (!$category) {
            return response('Category not found', Response::HTTP_NOT_FOUND);
        }

        return $category;
    }
}
