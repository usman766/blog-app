<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;




Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    // Blogs routes
    Route::resource('/blogs', BlogController::class);

    // Force delete and restore for blogs
    Route::delete('/blogs/{blog}/force-delete', [BlogController::class, 'forceDelete']);
    Route::post('/blogs/{blog}/restore', [BlogController::class, 'restore']);
});
