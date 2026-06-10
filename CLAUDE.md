# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# First-time setup
composer run setup

# Start all dev processes (server + queue + logs + vite hot reload)
composer run dev

# Run tests
composer run test

# Run a single test file
php artisan test tests/Feature/ExampleTest.php

# Run a single test method
php artisan test --filter=test_method_name

# Code style formatting (Laravel Pint)
./vendor/bin/pint

# Database
php artisan migrate
php artisan migrate:fresh --seed
php artisan db:seed --class=RoleSeeder

# Frontend only
npm run dev     # Vite dev server
npm run build   # Production build
```

## Architecture

**Debesties CMS** is a Laravel 13 monolithic content management system for publishing articles/blog posts. Stack: PHP 8.3, Laravel 13, Blade, Tailwind CSS v4, Vite, Alpine.js, SQLite (dev) / MariaDB (production).

### Route Separation

Routes are split across files loaded in `bootstrap/app.php`:
- `routes/web.php` — public-facing pages (home, search, author, category, tag, article)
- `routes/admin.php` — all `/admin/*` routes, prefixed `admin.` and grouped under `prefix('admin')`
- `routes/api.php`, `routes/auth.php` — stubs, currently empty

The public article route `/{post:slug}` uses a regex constraint `^(?!admin$).*$` to prevent intercepting admin URLs.

**Admin routes are not yet protected by auth middleware** — `['auth', 'admin']` middleware should be added to the `admin.php` group when authentication is implemented.

### Controller Layers

Controllers are separated into two namespaces:
- `App\Http\Controllers\Public\` — public site (HomeController, ArticleController, CategoryController, TagController, AuthorController, SearchController, SitemapController)
- `App\Http\Controllers\Admin\` — admin dashboard (DashboardController, PostController, CategoryController, TagController, MediaController, UserController, RoleController, CommentController, CalendarController, AnalyticsController, SeoController, AiVisibilityController, SettingController, MenuController, HomepageBuilderController)

### Business Logic Layers

Controllers should stay thin. Business logic lives in:
- `app/Actions/` — single-responsibility action classes (Posts: CreatePost, UpdatePost, DeletePost, PublishPost, SchedulePost; Media: UploadMedia, DeleteMedia, GenerateImageVariants; SEO: GenerateSlug, BuildMetaData, SuggestInternalLinks)
- `app/Services/` — cross-cutting service classes (PostService, MediaService, SeoService, AnalyticsService, AiVisibilityService, MenuService, SettingsService)
- `app/Jobs/` — background work (PublishScheduledPost, OptimizeMedia, GenerateSeoSuggestions)
- `app/Observers/` — model event hooks (PostObserver, MediaObserver, UserObserver)

### Post Model

`Post` uses `SoftDeletes` and `$guarded = []`. JSON columns (`faq`, `sources`, `key_facts`) are cast to arrays. Status lifecycle: `draft → review → approved → scheduled → published → archived`.

Key relationships: `belongsTo(User)`, `belongsTo(Category)`, `belongsToMany(Tag)`, `hasMany(Comment)`, `hasMany(PostMeta)`.

### Authorization

Custom RBAC via `roles`, `permissions`, `role_permissions`, and `user_roles` tables. Policy stubs exist in `app/Policies/` (PostPolicy, MediaPolicy, UserPolicy, CommentPolicy) but are not yet wired up. No third-party permission package — it's hand-rolled.

### Views

Views mirror the controller split:
- `resources/views/public/` — public pages
- `resources/views/admin/` — admin dashboard, one subdirectory per feature section, plus `layouts/`

### Frontend

Tailwind CSS v4 (imported via `@tailwindcss/vite` plugin, not a config file). Main entry points: `resources/css/app.css` (public) and `resources/css/admin.css` (admin), `resources/js/app.js`. Alpine.js is the intended interactivity layer — no Vue/React.

### Testing

PHPUnit with SQLite in-memory for tests. Feature tests in `tests/Feature/`, unit tests in `tests/Unit/`. Queue is set to `sync` in the test environment.
