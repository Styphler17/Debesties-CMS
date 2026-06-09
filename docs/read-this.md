```text
debesties-cms/
├── app/
│   ├── Actions/
│   │   ├── Posts/
│   │   │   ├── CreatePost.php
│   │   │   ├── UpdatePost.php
│   │   │   ├── DeletePost.php
│   │   │   ├── PublishPost.php
│   │   │   └── SchedulePost.php
│   │   ├── Media/
│   │   │   ├── UploadMedia.php
│   │   │   ├── DeleteMedia.php
│   │   │   └── GenerateImageVariants.php
│   │   └── SEO/
│   │       ├── GenerateSlug.php
│   │       ├── BuildMetaData.php
│   │       └── SuggestInternalLinks.php
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Public/
│   │   │   │   ├── HomeController.php
│   │   │   │   ├── ArticleController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── TagController.php
│   │   │   │   ├── AuthorController.php
│   │   │   │   ├── SearchController.php
│   │   │   │   └── SitemapController.php
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php
│   │   │       ├── PostController.php
│   │   │       ├── CategoryController.php
│   │   │       ├── TagController.php
│   │   │       ├── MediaController.php
│   │   │       ├── CalendarController.php
│   │   │       ├── AnalyticsController.php
│   │   │       ├── SeoController.php
│   │   │       ├── AiVisibilityController.php
│   │   │       ├── UserController.php
│   │   │       ├── RoleController.php
│   │   │       ├── CommentController.php
│   │   │       ├── SettingController.php
│   │   │       ├── MenuController.php
│   │   │       └── HomepageBuilderController.php
│   │   ├── Requests/
│   │   │   ├── Admin/
│   │   │   └── Public/
│   │   └── Middleware/
│   │
│   ├── Models/
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Permission.php
│   │   ├── Post.php
│   │   ├── PostMeta.php
│   │   ├── Category.php
│   │   ├── Tag.php
│   │   ├── Media.php
│   │   ├── Comment.php
│   │   ├── Page.php
│   │   ├── Menu.php
│   │   ├── MenuItem.php
│   │   ├── Setting.php
│   │   ├── ActivityLog.php
│   │   ├── PostFaq.php
│   │   ├── PostSource.php
│   │   ├── PostRelated.php
│   │   └── PostInternalLink.php
│   │
│   ├── Policies/
│   │   ├── PostPolicy.php
│   │   ├── MediaPolicy.php
│   │   ├── UserPolicy.php
│   │   └── CommentPolicy.php
│   │
│   ├── Services/
│   │   ├── PostService.php
│   │   ├── MediaService.php
│   │   ├── SeoService.php
│   │   ├── AnalyticsService.php
│   │   ├── AiVisibilityService.php
│   │   ├── MenuService.php
│   │   └── SettingsService.php
│   │
│   ├── Jobs/
│   │   ├── PublishScheduledPost.php
│   │   ├── OptimizeMedia.php
│   │   └── GenerateSeoSuggestions.php
│   │
│   ├── Observers/
│   │   ├── PostObserver.php
│   │   ├── MediaObserver.php
│   │   └── UserObserver.php
│   │
│   └── View/
│       └── Components/
│           ├── Admin/
│           └── Public/
│
├── database/
│   ├── migrations/
│   ├── seeders/
│   │   ├── RoleSeeder.php
│   │   ├── PermissionSeeder.php
│   │   ├── UserSeeder.php
│   │   ├── CategorySeeder.php
│   │   └── SettingSeeder.php
│   └── factories/
│       ├── UserFactory.php
│       ├── PostFactory.php
│       └── CategoryFactory.php
│
├── resources/
│   ├── views/
│   │   ├── public/
│   │   │   ├── home.blade.php
│   │   │   ├── article.blade.php
│   │   │   ├── category.blade.php
│   │   │   ├── tag.blade.php
│   │   │   ├── author.blade.php
│   │   │   └── search.blade.php
│   │   └── admin/
│   │       ├── dashboard/
│   │       ├── posts/
│   │       ├── categories/
│   │       ├── tags/
│   │       ├── media/
│   │       ├── calendar/
│   │       ├── analytics/
│   │       ├── seo/
│   │       ├── ai-visibility/
│   │       ├── users/
│   │       ├── roles/
│   │       ├── comments/
│   │       ├── settings/
│   │       ├── menus/
│   │       └── homepage-builder/
│   ├── css/
│   └── js/
│
├── routes/
│   ├── web.php
│   ├── admin.php
│   └── api.php
│
├── public/
│   ├── uploads/
│   └── assets/
│
├── storage/
├── tests/
│   ├── Feature/
│   └── Unit/
└── .env
```

## Better route separation

Use separate route files instead of putting everything in `web.php`.

```php
// routes/web.php

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/author/{user:slug}', [AuthorController::class, 'show'])->name('authors.show');

Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/tag/{tag:slug}', [TagController::class, 'show'])->name('tags.show');

Route::get('/{post:slug}', [ArticleController::class, 'show'])->name('posts.show');
```

```php
// routes/admin.php

use Illuminate\Support\Facades\Route;

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
```

Then load it in:

```php
// bootstrap/app.php

->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    then: function () {
        Route::middleware('web')
            ->group(base_path('routes/admin.php'));

        Route::middleware('web')
            ->group(base_path('routes/auth.php'));
    },
)
```

## Main database tables

```text
users
roles
permissions
role_user
permission_role

posts
categories
tags
post_tag
media
comments

menus
menu_items
settings
post_views
redirects
```

## Posts table fields

```text
id
user_id
category_id
title
slug
excerpt
content
quick_answer
key_facts
faq
sources
featured_image_id
status
visibility
published_at
scheduled_at
updated_at
seo_title
seo_description
focus_keyword
search_intent
canonical_url
schema_type
og_title
og_description
og_image_id
views_count
created_at
updated_at
deleted_at
```

## Recommended stack inside Laravel

```text
Laravel
MariaDB
Blade
Alpine.js
Vite
Custom CSS
Laravel Breeze or Fortify for auth
Spatie Laravel Permission for roles
Intervention Image for image processing
Laravel Scheduler for scheduled posts
Laravel Queues for heavy image processing
```

## Best architecture choice

For your case:

```text
Laravel monolith
Blade frontend
Blade admin dashboard
MariaDB database
Custom CSS
Small Alpine.js interactions
No separate frontend app yet
```

Do not start with React/Vue SPA unless the CMS becomes complex later. For Hostinger shared/cloud hosting, the Laravel monolith is cleaner, cheaper, easier to deploy, and easier to maintain.
