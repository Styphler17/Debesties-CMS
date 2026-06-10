<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AiVisibilityController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomepageBuilderController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Admin auth routes (no middleware — these are the login/logout pages)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Protected admin routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('posts', PostController::class);
        Route::post('posts/{post}/publish', [PostController::class, 'publish'])->name('posts.publish');
        Route::post('posts/{post}/schedule', [PostController::class, 'schedule'])->name('posts.schedule');
        Route::resource('categories', CategoryController::class);
        Route::resource('tags', TagController::class);
        Route::resource('media', MediaController::class)->only(['index', 'store', 'show', 'destroy']);
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('comments', CommentController::class);

        Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
        Route::get('ai-visibility', [AiVisibilityController::class, 'index'])->name('ai-visibility.index');
        Route::get('homepage-builder', [HomepageBuilderController::class, 'index'])->name('homepage-builder.index');
    });
