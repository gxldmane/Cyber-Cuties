<?php

use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('categories', 'index');
        Route::get('categories/{id}', 'show');
    });

    Route::controller(\App\Http\Controllers\api\v1\RankController::class)->group(function () {
        Route::get('ranks/{id}', 'show');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'getAllCuties');
        Route::get('users/{id}', 'show');
    });
});
