<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CategoryController extends Controller
{
    public CategoryService $service;
    public function __construct(CategoryService $categoryService)
    {
        $this->service = $categoryService;
    }

    public function index()
    {
        return response()->json([
            'data' => $this->service->getAllCategories()
        ],
            ResponseAlias::HTTP_OK
        );
    }

    public function show(int $id)
    {
        $category = $this->service->getCategoryById($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ],
                ResponseAlias::HTTP_NOT_FOUND
            );
        }

        return response()->json([
            'data' => $category
        ],
            ResponseAlias::HTTP_OK
        );
    }
}
