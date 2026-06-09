<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SettingController;

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('posts', PostController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('tags', TagController::class);
        Route::resource('media', MediaController::class)->only(['index', 'store', 'show', 'destroy']);
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);

        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    });
