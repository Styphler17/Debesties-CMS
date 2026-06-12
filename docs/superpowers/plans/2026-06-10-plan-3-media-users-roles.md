# Media Library + Users/Roles/Permissions — Implementation Plan (3 of 4)

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Implement the media upload pipeline (upload, GD variants, delete with reference guard) and full Users/Roles administration plus public profile/bookmarks.

**Architecture:** Controllers call Actions for media (UploadMedia, DeleteMedia, GenerateImageVariants). Users/Roles use direct Model operations guarded by FormRequests. OptimizeMedia job generates variants async. UserObserver assigns default role and cleans sessions. All admin routes already protected by `admin` middleware.

**Tech Stack:** Laravel 13, PHP 8.3 (GD extension, no new packages), PHPUnit, `Storage::fake('public')` in tests.

**PHP binary:** `/c/MAMP/bin/php/php8.3.1/php.exe`

**Run tests with:** `/c/MAMP/bin/php/php8.3.1/php.exe artisan test --filter=ClassName`

---

## Orientation: Key Facts

- `media` table columns: `user_id`, `file_name`, `file_path`, `file_url`, `mime_type`, `file_size`, `alt_text`, `caption`, `title`, `folder`, `width`, `height`, timestamps, `deleted_at`. The current `Media` model fillable (`filename`, `path`, `size`) does **not** match — fix it in Task 1.
- Media migration has `softDeletes()` but media is hard-deleted by design (files are destroyed). Remove `softDeletes()` from the migration in Task 1 (same precedent as the tags table in Plan 2).
- `posts.featured_image_id` is a FK to `media`. `DeleteMedia` must refuse to delete referenced media.
- `Permission` model fillable includes `description` but the migration has no such column — fix in Task 1.
- No `Bookmark` model exists; the `bookmarks` table does (user_id, post_id, unique pair). Create the model in Task 1.
- `User` model already has `roles()`, `hasPermission()`, SoftDeletes, `password => 'hashed'` cast. Fillable: name, slug, email, password, avatar, bio, status, newsletter, last_login_at.
- `users.status` is enum `active|suspended`.
- Routes already registered in `routes/admin.php`: `Route::resource('media', ...)->only(['index','store','show','destroy'])`, `Route::resource('users', ...)`, `Route::resource('roles', ...)`. No route changes needed for admin; public profile/bookmark routes are added in Task 8.
- Seeder permissions (slugs): posts.create, posts.edit, posts.publish, posts.delete, categories.manage, tags.manage, media.upload, media.delete, users.manage, roles.manage, comments.moderate, settings.manage. Roles: `subscriber`, `super_admin`.
- Admin middleware passes any user having a role with slug != `subscriber`. In tests: create role `super_admin`, attach to user, `actingAs($user)`.
- Public disk: root `storage/app/public`, URL `{APP_URL}/storage`. Store uploads at `uploads/originals/{uuid}.{ext}`, variants at `uploads/{thumb|medium|large}/{uuid}.{ext}`.
- All media/user/role admin views currently use fake `@php` arrays — wired to real data in Tasks 4 and 7.
- `GenerateSlug` action exists at `app/Actions/SEO/GenerateSlug.php` — signature `handle(string $title, string $table): string`. Use for user slugs.
- Stub files to replace in place (do not create new paths): `app/Actions/Media/UploadMedia.php`, `DeleteMedia.php`, `GenerateImageVariants.php`, `app/Jobs/OptimizeMedia.php`, `app/Observers/MediaObserver.php`, `app/Observers/UserObserver.php`, `app/Services/MediaService.php`, `app/Http/Controllers/Admin/MediaController.php`, `UserController.php`, `RoleController.php`.

---

## Task 1: Fix Media + Permission Models, Create Bookmark Model, Fix Media Migration

**Files to modify:**
- `app/Models/Media.php`
- `app/Models/Permission.php`
- `database/migrations/0001_01_01_000070_create_media_table.php` (remove softDeletes)

**File to create:**
- `app/Models/Bookmark.php`

No new tests — existing suite is the safety net.

- [ ] **Step 1.1: Replace `app/Models/Media.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_name',
        'file_path',
        'file_url',
        'mime_type',
        'file_size',
        'alt_text',
        'caption',
        'title',
        'folder',
        'width',
        'height',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

- [ ] **Step 1.2: Replace `app/Models/Permission.php`** (remove `description` from fillable)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];
}
```

- [ ] **Step 1.3: Create `app/Models/Bookmark.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = ['user_id', 'post_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
```

- [ ] **Step 1.4: Edit `database/migrations/0001_01_01_000070_create_media_table.php`** — delete the `$table->softDeletes();` line. Leave everything else untouched.

- [ ] **Step 1.5: Run full test suite**

Run: `/c/MAMP/bin/php/php8.3.1/php.exe artisan test`
Expected: all 52 tests pass.

- [ ] **Step 1.6: Commit**

```bash
git add app/Models/Media.php app/Models/Permission.php app/Models/Bookmark.php \
        database/migrations/0001_01_01_000070_create_media_table.php
git commit -m "fix: align Media/Permission fillable with schema, add Bookmark model, remove media softDeletes"
```

---
