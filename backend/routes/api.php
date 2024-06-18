<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\RankController;
use App\Http\Controllers\api\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    });

    Route::controller(RankController::class)->prefix('ranks')->group(function () {
        Route::get('/{id}', 'show');
    });

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/', 'getAllCuties');
        Route::get('/{id}', 'show');
    });
});
