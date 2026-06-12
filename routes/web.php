<?php

use App\Http\Controllers\Public\ArticleController;
use App\Http\Controllers\Public\AuthorController;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\CommentController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\SearchController;
use App\Http\Controllers\Public\SitemapController;
use App\Http\Controllers\Public\TagController;
use App\Http\Controllers\Public\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/author/{user:slug}', [AuthorController::class, 'show'])->name('authors.show');

Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/tag/{tag:slug}', [TagController::class, 'show'])->name('tags.show');

Route::get('/pages/{page:slug}', [PageController::class, 'show'])->name('pages.show');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->name('posts.comments.store')
    ->middleware('auth');

Route::get('/{post:slug}', [ArticleController::class, 'show'])
    ->name('posts.show')
    ->where('post', '^(?!admin$|register$|login$|logout$|forgot-password$|reset-password$|sitemap\.xml$)[^/]+$');
