<?php

use Illuminate\Support\Facades\Route;

// Public Endpoints
Route::get('/posts', [App\Http\Controllers\Api\PostController::class, 'index']);
Route::get('/posts/{slug}', [App\Http\Controllers\Api\PostController::class, 'show']);
Route::get('/categories', [App\Http\Controllers\Api\CategoryController::class, 'index']);
Route::get('/tags', [App\Http\Controllers\Api\TagController::class, 'index']);
Route::get('/settings', [App\Http\Controllers\Api\SettingController::class, 'index']);

// Auth Endpoints
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

// Authenticated Subscriber Endpoints
Route::middleware('auth.api')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/me', [App\Http\Controllers\Api\ProfileController::class, 'show']);
    Route::put('/me', [App\Http\Controllers\Api\ProfileController::class, 'update']);
    
    Route::get('/bookmarks', [App\Http\Controllers\Api\BookmarkController::class, 'index']);
    Route::post('/bookmarks', [App\Http\Controllers\Api\BookmarkController::class, 'toggle']);
    
    Route::post('/posts/{slug}/comments', [App\Http\Controllers\Api\CommentController::class, 'store']);
});
