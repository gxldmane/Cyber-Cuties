<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\ProfileController;
use App\Http\Controllers\api\v1\RankController;
use App\Http\Controllers\api\v1\ReviewController;
use App\Http\Controllers\api\v1\ServiceController;
use App\Http\Controllers\api\v1\ServiceTypeController;
use App\Http\Controllers\api\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::controller(ProfileController::class)->prefix('me')->group(function () {
            Route::get('/', 'show');
            Route::patch('/', 'update');
        });

        Route::controller(ServiceController::class)->prefix('services')->group(function () {
            Route::get('/{id}', 'show');
            Route::post('/', 'store')->middleware('ability:cutie');
            Route::patch('/{id}', 'update')->middleware('ability:cutie');
            Route::delete('/{id}', 'destroy')->middleware('ability:cutie');
        });

        Route::controller(ServiceTypeController::class)->prefix('services/{serviceId}/types')->group(function () {
            Route::post('/', 'store')->middleware('ability:cutie');
            Route::patch('/{id}', 'update')->middleware('ability:cutie');
            Route::delete('/{id}', 'destroy')->middleware('ability:cutie');
        });

        Route::controller(ReviewController::class)->prefix('services/{serviceId}/reviews')->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
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

});
