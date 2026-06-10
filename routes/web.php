<?php

use App\Http\Controllers\Public\ArticleController;
use App\Http\Controllers\Public\AuthorController;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\SearchController;
use App\Http\Controllers\Public\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/author/{user:slug}', [AuthorController::class, 'show'])->name('authors.show');

Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/tag/{tag:slug}', [TagController::class, 'show'])->name('tags.show');

Route::get('/{post:slug}', [ArticleController::class, 'show'])
    ->name('posts.show')
    ->where('post', '^(?!admin$|register$|login$|logout$|forgot-password$|reset-password$)[^/]+$');
