# Backend Completion Design — Debesties CMS
**Date:** 2026-06-10
**Approach:** Actions wired directly from Controllers. Services handle cross-cutting logic. No fat controllers, no extra service indirection beyond what's needed.

---

## Architecture Pattern

- Controllers → Actions (business logic) → Models
- Controllers → Services (cross-cutting: SEO, settings, menus, analytics, media URLs)
- Observers handle lifecycle side-effects (cleanup, logging, role assignment)
- Jobs handle async work (media optimization, SEO suggestions, scheduled publishing, welcome email)
- FormRequests handle all input validation

---

## 1. Auth

### Admin Login
- Route: `GET|POST /admin/login` → `AdminAuthController`
- `LoginRequest`: email (required, email), password (required), remember_me (boolean)
- `Auth::attempt()` with `remember_me` flag
- Success → redirect to `admin.dashboard`
- Failure → back with validation error
- Logout: `POST /admin/logout` → clears session → redirect to `/admin/login`

### Public Auth (routes/auth.php)
- `GET|POST /register` → `RegisterController`
  - `RegisterRequest`: name, email, password, password_confirmation
  - Creates `User`, assigns `subscriber` role, dispatches `SendWelcomeEmail` job
- `GET|POST /login` → `LoginController`
- `POST /logout` → `LogoutController`
- `GET|POST /forgot-password` → `ForgotPasswordController` — `Password::sendResetLink()`
- `GET|POST /reset-password/{token}` → `ResetPasswordController` — `Password::reset()`

### Middleware
- `auth` — requires login (Laravel built-in)
- `admin` — checks user has any non-subscriber role; redirects to `/admin/login` if not

### Roles & Seeding
- Seeder creates `super_admin` role with all permissions on first run
- Public users always assigned `subscriber` role (no admin access)
- First admin assigned via artisan command or seeder

### Newsletter Column
- New migration: add `newsletter` boolean (default true) to `users` table

---

## 2. Posts CRUD

### Actions

**`CreatePost::handle(array $data, User $user): Post`**
- Generates slug via `GenerateSlug` action
- Creates `Post` record
- Creates `PostMeta` record (empty defaults)
- Syncs tags via `post_tags` pivot
- Returns created Post

**`UpdatePost::handle(Post $post, array $data): Post`**
- Regenerates slug only if title changed
- Updates Post + PostMeta
- Re-syncs tags
- Returns updated Post

**`DeletePost::handle(Post $post): void`**
- Soft deletes Post (observer handles all pivot/meta cleanup)

**`PublishPost::handle(Post $post): void`**
- Sets `status = published`, `published_at = now()`
- Saves

**`SchedulePost::handle(Post $post, string $scheduledAt): void`**
- Sets `status = scheduled`, `scheduled_at = $scheduledAt`
- Dispatches `PublishScheduledPost` job delayed to `scheduled_at`

### Controller Routes (additional beyond resource)
- `POST /admin/posts/{post}/publish` → `PostController@publish`
- `POST /admin/posts/{post}/schedule` → `PostController@schedule`

### Requests
- `StorePostRequest`: title (required), body (required), category_id (required, exists), tags[] (array, exists), featured_image_id (nullable, exists), status (in: draft,published,scheduled)
- `UpdatePostRequest`: same rules, all nullable except title

### `GenerateSlug` Action
- `Str::slug($title)`, checks uniqueness on target table
- Appends `-2`, `-3`, etc. until unique

### `PostObserver`
- `created/updated` → dispatches `GenerateSeoSuggestions` job (async)
- `deleted` → cleans up `post_meta`, `post_tags`, `post_related`, `post_internal_links`, `post_faqs`, `post_sources`

### `PublishScheduledPost` Job
- Re-checks `status = scheduled` before acting
- Calls `PublishPost::handle($post)`

---

## 3. Categories & Tags

### Categories
- No dedicated Action — direct Model operations
- `StoreCategoryRequest`: name (required), parent_id (nullable, exists), sort_order (integer), is_visible (boolean)
- `UpdateCategoryRequest`: same, all nullable
- Slug auto-generated via `GenerateSlug` on store; regenerated on name change
- `destroy`: blocks deletion if category has posts (returns validation error); reassigns children to parent or null before deleting

### Tags
- No dedicated Action
- `StoreTagRequest`: name (required)
- `UpdateTagRequest`: name (required)
- Slug auto-generated via `GenerateSlug`
- `destroy`: detaches from all posts, then hard deletes

### Slug Uniqueness
- Scoped per model (category slugs unique among categories, tag slugs unique among tags)

---

## 4. Media Library

### `UploadMedia::handle(UploadedFile $file, User $user): Media`
- Validates: mime (jpeg, png, gif, webp), max 10MB
- Generates filename: `{uuid}.{ext}`
- Stores original to `public/uploads/originals/`
- Creates `Media` record (disk, path, mime_type, size, original_name, user_id)
- Dispatches `OptimizeMedia` job with media id
- Returns Media record

### `OptimizeMedia` Job
- Uses PHP built-in GD (no new packages)
- Generates 3 variants:
  - `thumb` — 300×200 cropped
  - `medium` — 800px wide, proportional height
  - `large` — 1200px wide, proportional height
- Stores to `public/uploads/{thumb|medium|large}/`
- Updates Media record with variant paths

### `DeleteMedia::handle(Media $media): void`
- Checks no Post references this media as `featured_image_id` (returns error if referenced)
- Deletes all variant files and original from disk
- Deletes Media record

### `MediaController`
- `store` → `StoreMediaRequest` (file required, image mime) → `UploadMedia::handle()` → JSON {id, urls}
- `show` → media detail for post editor image picker
- `destroy` → `DeleteMedia::handle()` → JSON response
- `index` → paginated grid, filterable by mime type

### `MediaObserver`
- `deleted` → safety cleanup of any orphaned files

### `MediaService::url(Media $media, string $variant): string`
- Resolves public URL for variant (`thumb`, `medium`, `large`, `original`)

---

## 5. Users, Roles & Permissions

### Permissions
- String-keyed: `posts.create`, `posts.edit`, `posts.publish`, `posts.delete`, `categories.manage`, `tags.manage`, `media.upload`, `media.delete`, `users.manage`, `roles.manage`, `comments.moderate`, `settings.manage`
- Seeder creates full permission set on first run

### Authorization Helper
- `$user->hasPermission(string $key): bool`
- Queries `user_roles` → `role_permissions` → `permissions`
- Result cached per-request on User model to avoid N+1

### `RoleController`
- `store` → `StoreRoleRequest` (name required, permissions[] array) → creates Role, syncs permissions pivot
- `update` → `UpdateRoleRequest` → updates Role + re-syncs permissions
- `destroy` → blocks deletion of roles with assigned users

### `UserController`
- `store` → `StoreUserRequest` (name, email, password, roles[]) → creates User, assigns roles
- `update` → `UpdateUserRequest` (name, email, roles[], avatar) → updates user + role assignments
- `destroy` → blocks self-deletion; reassigns/nullifies authored posts; soft deletes user
- `index` → paginated, filterable by role

### Public Profile
- `GET|POST /profile` → `ProfileController` (new public route)
- Update: name, avatar, bio, newsletter boolean, password change
- Bookmarks: `POST|DELETE /bookmarks/{post}` → `BookmarkController`
  - Stores in `bookmarks` table (user_id, post_id) — direct DB query, no Model class needed

### `UserObserver`
- `created` → assigns default role if none provided, logs activity
- `deleted` → revokes active sessions via `Auth::logoutOtherDevices()`

---

## 6. Comments

### Public Submission
- Route: `POST /posts/{post}/comments` → `CommentController@store` (public, auth required)
- `StoreCommentRequest`: body (required, min 2), parent_id (nullable, exists, max 1 level deep)
- Auto-approval: if user has prior approved comment → `status = approved`; otherwise `status = pending`
- Guests cannot comment (must be logged in)

### Admin Moderation (`Admin\CommentController`)
- `index` → paginated, filterable by status (pending/approved/spam), post, user
- `update` → approve/reject/mark spam — `UpdateCommentRequest` (status: pending|approved|spam)
- `destroy` → hard delete
- No `create`/`store` — admins don't author comments via CMS

### `CommentObserver`
- `created` → if `status = pending`, logs activity for admin review queue

### `CommentPolicy`
- Already complete — wired via `$this->authorize()` in controller

### Public Display
- Comments query always scoped to `status = approved`

---

## 7. Public Frontend Controllers

### `HomeController`
- Featured posts: `Post::published()->pinned()->orLatest()->limit(5)->get()`
- Latest posts: paginated (12/page)
- Section blocks: posts grouped by top-level categories

### `ArticleController`
- Find by slug, `status = published`, 404 otherwise
- Increment `view_count` via `Post::where('id', $post->id)->increment('view_count')`
- Load relations: category, tags, author, approved comments (with replies), related posts
- Pass `PostMeta` to view for SEO via `SeoService::buildMeta($post)`

### `CategoryController` (Public)
- Find category by slug, 404 if not found
- Paginated published posts scoped to category, ordered by `published_at` desc

### `TagController` (Public)
- Find tag by slug, 404 if not found
- Paginated published posts scoped to tag, ordered by `published_at` desc

### `AuthorController`
- Find user by slug, 404 if not found or no published posts
- Paginated published posts by author, ordered by `published_at` desc

### `SearchController`
- Query param: `q` (min 2 chars, redirect back if shorter)
- `LIKE %query%` on `posts.title` and `posts.body`, scoped to published
- Paginated results (10/page)

### `SitemapController`
- Returns XML response (`Content-Type: application/xml`)
- Includes all published posts, categories, tags with their slugs and `updated_at`
- Cached 1 hour via `Cache::remember('sitemap', 3600, fn() => ...)`

---

## 8. Services, Observers & Jobs

### Services

**`SeoService::buildMeta(Post $post): array`**
- Returns og:title, og:description, canonical URL, JSON-LD structured data from `PostMeta`

**`SettingsService::get(string $key, mixed $default = null): mixed`**
- Cached lookup into `settings` table (site name, logo, tagline, etc.)

**`MenuService::getMenu(string $location): Menu`**
- Fetches menu + nested items for named location (header, footer)
- Cached per location key

**`AnalyticsService::topPosts(int $days = 30): Collection`**
- Queries posts ordered by `view_count` for dashboard charts

**`MediaService::url(Media $media, string $variant = 'original'): string`**
- Resolves public URL for a media variant

### Observer Summary
| Observer | Event | Action |
|---|---|---|
| PostObserver | created/updated | Dispatch `GenerateSeoSuggestions` |
| PostObserver | deleted | Cleanup related pivot/meta tables |
| MediaObserver | deleted | Delete variant files from disk |
| UserObserver | created | Assign default role, log activity |
| UserObserver | deleted | Revoke sessions |
| CommentObserver | created (pending) | Log for admin review queue |

### Jobs Summary
| Job | Trigger | Action |
|---|---|---|
| `PublishScheduledPost` | Delayed queue at `scheduled_at` | Re-check status, call `PublishPost::handle()` |
| `OptimizeMedia` | After `UploadMedia` | Generate thumb/medium/large variants via GD |
| `GenerateSeoSuggestions` | After Post save | Populate `post_meta` from post content/tags |
| `SendWelcomeEmail` | After user registration | Send welcome Mailable via queue |

### `GenerateSeoSuggestions` Job
- Truncates post excerpt to 160 chars → saves as `meta_description` in `PostMeta`
- Pulls tag names → saves as `meta_keywords`

### `SendWelcomeEmail`
- Queued `Mailable` dispatched on `User::created` via `RegisterController`
- Sends to new user's email

---

## New Files Required

### Migrations
- `add_newsletter_to_users_table` — adds `newsletter` boolean default true
- `create_bookmarks_table` — user_id, post_id, timestamps (unique constraint on pair)

### New Controllers
- `App\Http\Controllers\Admin\AdminAuthController`
- `App\Http\Controllers\Public\RegisterController`
- `App\Http\Controllers\Public\LoginController`
- `App\Http\Controllers\Public\LogoutController`
- `App\Http\Controllers\Public\ForgotPasswordController`
- `App\Http\Controllers\Public\ResetPasswordController`
- `App\Http\Controllers\Public\ProfileController`
- `App\Http\Controllers\Public\BookmarkController`
- `App\Http\Controllers\Public\CommentController`

### New FormRequests (app/Http/Requests/Admin/ and Public/)
- `LoginRequest`, `RegisterRequest`
- `StorePostRequest`, `UpdatePostRequest`
- `StoreCategoryRequest`, `UpdateCategoryRequest`
- `StoreTagRequest`, `UpdateTagRequest`
- `StoreMediaRequest`
- `StoreUserRequest`, `UpdateUserRequest`
- `StoreRoleRequest`, `UpdateRoleRequest`
- `StoreCommentRequest` (public), `UpdateCommentRequest` (admin)

### New Job
- `App\Jobs\SendWelcomeEmail`

### New Mailable
- `App\Mail\WelcomeEmail`

### New Seeder
- `RolesAndPermissionsSeeder` — creates full permission set + super_admin role

---

## Out of Scope (this phase)
- External analytics API integrations
- AI-powered content suggestions beyond basic SEO meta
- Newsletter broadcast sending (subscribers collected, sending deferred)
- Homepage Builder, Calendar UI logic (index-only views acceptable for now)
- API endpoints (api.php remains placeholder)
