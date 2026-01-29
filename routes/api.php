<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\BlogCategoryController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.basic')->group(function () {
    Route::apiResource('blogs', BlogController::class);
    Route::apiResource('blog-categories', BlogCategoryController::class);
    Route::post('/media', [MediaController::class, 'upload']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
