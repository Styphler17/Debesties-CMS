# Posts + Categories + Tags — Implementation Plan (2 of 4)

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Implement full Posts CRUD with actions/observer/jobs, plus Categories and Tags management, wired to existing admin views.

**Architecture:** Controllers call Actions for Posts (Create/Update/Delete/Publish/Schedule). Categories and Tags use direct Model operations. GenerateSlug is a shared action. PostObserver fires GenerateSeoSuggestions async. All admin routes protected by `admin` middleware.

**Tech Stack:** Laravel 13, PHP 8.3, PHPUnit feature tests, Queue jobs (sync in tests).

**PHP binary:** `/c/MAMP/bin/php/php8.3.1/php.exe`

**Run tests with:** `/c/MAMP/bin/php/php8.3.1/php.exe artisan test --filter=ClassName`

---

## Orientation: Key Facts

- `GenerateSlug` already exists at `app/Actions/SEO/GenerateSlug.php` (stub with wrong signature). Replace it in place — do **not** create a new file at `app/Actions/GenerateSlug.php`.
- All five Post action stubs exist in `app/Actions/Posts/` but all have wrong signatures. Replace them.
- All three Jobs exist in `app/Jobs/` as stubs. Replace them.
- `PostObserver` exists at `app/Observers/PostObserver.php` as a stub. Replace it.
- The `admin` middleware checks that the authenticated user has a role with slug != `subscriber`. In tests, `actingAs($user)` with a `super_admin` role user passes the middleware.
- `Post` uses `$guarded = []` — no fillable restriction.
- Tag model has NO `SoftDeletes` — `$tag->delete()` is a hard delete.
- Category DOES use SoftDeletes (needs to be added to the model).
- `post_meta` table has named SEO columns, not key-value pairs.
- The pivot table for post-tag is explicitly named `post_tags` (needs to be declared in both `Post::tags()` and `Tag::posts()`).
- The `scheduled_for` column name (not `scheduled_at`).
- `PostMeta` is `hasOne` on Post (one record per post), not `hasMany`.

---

## Task 1: GenerateSlug Action

**Files to modify:**
- `app/Actions/SEO/GenerateSlug.php` — replace stub

**File to create:**
- `tests/Feature/Actions/GenerateSlugTest.php`

### Step 1.1 — Replace `app/Actions/SEO/GenerateSlug.php`

```php
<?php

namespace App\Actions\SEO;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateSlug
{
    public function handle(string $title, string $table): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (DB::table($table)->where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
```

### Step 1.2 — Create `tests/Feature/Actions/GenerateSlugTest.php`

```php
<?php

namespace Tests\Feature\Actions;

use App\Actions\SEO\GenerateSlug;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateSlugTest extends TestCase
{
    use RefreshDatabase;

    private GenerateSlug $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new GenerateSlug();
    }

    public function test_generates_basic_slug(): void
    {
        $slug = $this->action->handle('Awards History', 'categories');

        $this->assertSame('awards-history', $slug);
    }

    public function test_appends_2_on_collision(): void
    {
        Category::create([
            'name' => 'Awards History',
            'slug' => 'awards-history',
        ]);

        $slug = $this->action->handle('Awards History', 'categories');

        $this->assertSame('awards-history-2', $slug);
    }

    public function test_appends_3_on_double_collision(): void
    {
        Category::create(['name' => 'Awards History', 'slug' => 'awards-history']);
        Category::create(['name' => 'Awards History 2', 'slug' => 'awards-history-2']);

        $slug = $this->action->handle('Awards History', 'categories');

        $this->assertSame('awards-history-3', $slug);
    }
}
```

### Step 1.3 — Run tests

```bash
/c/MAMP/bin/php/php8.3.1/php.exe artisan test --filter=GenerateSlugTest
```

Expected: 3 tests pass.

### Step 1.4 — Commit

```bash
git add app/Actions/SEO/GenerateSlug.php tests/Feature/Actions/GenerateSlugTest.php
git commit -m "Implement GenerateSlug action with uniqueness suffix logic and tests"
```

---

## Task 2: Fix Post, PostMeta, Category, Tag Models

**Files to modify (full replacement):**
- `app/Models/Post.php`
- `app/Models/PostMeta.php`
- `app/Models/Category.php`
- `app/Models/Tag.php`

No tests written for model fixes — the existing test suite is the safety net.

### Step 2.1 — Replace `app/Models/Post.php`

Note: `#[ObservedBy]` attribute is NOT added yet — it's added in Task 4 after the observer is implemented.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'published_at'  => 'datetime',
        'scheduled_for' => 'datetime',
        'faq'           => 'array',
        'sources'       => 'array',
        'key_facts'     => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function meta()
    {
        return $this->hasOne(PostMeta::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
```

### Step 2.2 — Replace `app/Models/PostMeta.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'seo_title',
        'meta_description',
        'focus_keyword',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image_id',
        'twitter_card',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
```

### Step 2.3 — Replace `app/Models/Category.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
```

### Step 2.4 — Replace `app/Models/Tag.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }
}
```

### Step 2.5 — Run full test suite to verify nothing broke

```bash
/c/MAMP/bin/php/php8.3.1/php.exe artisan test
```

All existing tests should still pass.

### Step 2.6 — Commit

```bash
git add app/Models/Post.php app/Models/PostMeta.php app/Models/Category.php app/Models/Tag.php
git commit -m "Fix Post, PostMeta, Category, Tag models: correct casts, pivot names, fillable, SoftDeletes"
```

---

## Task 3: Post Actions (Create, Update, Delete, Publish) + Tests

Write the test first, then implement actions.

**Files to create:**
- `tests/Feature/Actions/PostActionsTest.php`
- (modify) `app/Actions/Posts/CreatePost.php`
- (modify) `app/Actions/Posts/UpdatePost.php`
- (modify) `app/Actions/Posts/DeletePost.php`
- (modify) `app/Actions/Posts/PublishPost.php`

### Step 3.1 — Create `tests/Feature/Actions/PostActionsTest.php`

```php
<?php

namespace Tests\Feature\Actions;

use App\Actions\Posts\CreatePost;
use App\Actions\Posts\DeletePost;
use App\Actions\Posts\PublishPost;
use App\Actions\Posts\UpdatePost;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostMeta;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PostActionsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $category;
    private Tag $tag1;
    private Tag $tag2;

    protected function setUp(): void
    {
        parent::setUp();

        Queue::fake();

        $this->user     = User::factory()->create();
        $this->category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
        $this->tag1     = Tag::create(['name' => 'PHP', 'slug' => 'php']);
        $this->tag2     = Tag::create(['name' => 'Laravel', 'slug' => 'laravel']);
    }

    public function test_create_generates_slug_creates_post_meta_and_syncs_tags(): void
    {
        $post = (new CreatePost())->handle([
            'title'       => 'Hello World',
            'body'        => '<p>Content here</p>',
            'category_id' => $this->category->id,
            'tags'        => [$this->tag1->id, $this->tag2->id],
            'status'      => 'draft',
        ], $this->user);

        // Post created with generated slug
        $this->assertDatabaseHas('posts', [
            'title'  => 'Hello World',
            'slug'   => 'hello-world',
            'user_id' => $this->user->id,
        ]);

        // PostMeta record created
        $this->assertDatabaseHas('post_meta', ['post_id' => $post->id]);

        // Tags synced
        $this->assertDatabaseHas('post_tags', ['post_id' => $post->id, 'tag_id' => $this->tag1->id]);
        $this->assertDatabaseHas('post_tags', ['post_id' => $post->id, 'tag_id' => $this->tag2->id]);

        $this->assertInstanceOf(Post::class, $post);
    }

    public function test_create_slug_is_unique_when_collision_exists(): void
    {
        Post::create(['title' => 'Hello World', 'slug' => 'hello-world', 'body' => 'x', 'user_id' => $this->user->id, 'status' => 'draft']);

        $post = (new CreatePost())->handle([
            'title'  => 'Hello World',
            'body'   => '<p>Different post</p>',
            'status' => 'draft',
        ], $this->user);

        $this->assertSame('hello-world-2', $post->slug);
    }

    public function test_update_regenerates_slug_when_title_changes(): void
    {
        $post = Post::create([
            'title'   => 'Original Title',
            'slug'    => 'original-title',
            'body'    => '<p>Body</p>',
            'user_id' => $this->user->id,
            'status'  => 'draft',
        ]);
        PostMeta::create(['post_id' => $post->id]);

        $updated = (new UpdatePost())->handle($post, [
            'title' => 'Updated Title',
            'body'  => '<p>Body</p>',
        ]);

        $this->assertSame('updated-title', $updated->fresh()->slug);
    }

    public function test_update_does_not_regenerate_slug_when_title_unchanged(): void
    {
        $post = Post::create([
            'title'   => 'Original Title',
            'slug'    => 'original-title',
            'body'    => '<p>Body</p>',
            'user_id' => $this->user->id,
            'status'  => 'draft',
        ]);
        PostMeta::create(['post_id' => $post->id]);

        $updated = (new UpdatePost())->handle($post, [
            'title' => 'Original Title',
            'body'  => '<p>Updated body</p>',
        ]);

        $this->assertSame('original-title', $updated->fresh()->slug);
    }

    public function test_update_resyncs_tags(): void
    {
        $post = Post::create([
            'title'   => 'Tagged Post',
            'slug'    => 'tagged-post',
            'body'    => '<p>Body</p>',
            'user_id' => $this->user->id,
            'status'  => 'draft',
        ]);
        PostMeta::create(['post_id' => $post->id]);
        $post->tags()->attach([$this->tag1->id]);

        (new UpdatePost())->handle($post, [
            'title' => 'Tagged Post',
            'body'  => '<p>Body</p>',
            'tags'  => [$this->tag2->id],
        ]);

        $this->assertDatabaseMissing('post_tags', ['post_id' => $post->id, 'tag_id' => $this->tag1->id]);
        $this->assertDatabaseHas('post_tags', ['post_id' => $post->id, 'tag_id' => $this->tag2->id]);
    }

    public function test_delete_soft_deletes_post(): void
    {
        $post = Post::create([
            'title'   => 'To Delete',
            'slug'    => 'to-delete',
            'body'    => '<p>Body</p>',
            'user_id' => $this->user->id,
            'status'  => 'draft',
        ]);

        (new DeletePost())->handle($post);

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    public function test_publish_sets_status_published_and_published_at(): void
    {
        $post = Post::create([
            'title'   => 'To Publish',
            'slug'    => 'to-publish',
            'body'    => '<p>Body</p>',
            'user_id' => $this->user->id,
            'status'  => 'draft',
        ]);

        (new PublishPost())->handle($post);

        $post->refresh();
        $this->assertSame('published', $post->status);
        $this->assertNotNull($post->published_at);
    }
}
```

### Step 3.2 — Replace `app/Actions/Posts/CreatePost.php`

```php
<?php

namespace App\Actions\Posts;

use App\Actions\SEO\GenerateSlug;
use App\Models\Post;
use App\Models\PostMeta;
use App\Models\User;

class CreatePost
{
    public function handle(array $data, User $user): Post
    {
        $slug = (new GenerateSlug())->handle($data['title'], 'posts');

        $post = Post::create([
            'user_id'           => $user->id,
            'title'             => $data['title'],
            'slug'              => $slug,
            'subtitle'          => $data['subtitle'] ?? null,
            'excerpt'           => $data['excerpt'] ?? null,
            'body'              => $data['body'],
            'status'            => $data['status'] ?? 'draft',
            'category_id'       => $data['category_id'] ?? null,
            'featured_image_id' => $data['featured_image_id'] ?? null,
        ]);

        PostMeta::create(['post_id' => $post->id]);

        if (!empty($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;
    }
}
```

### Step 3.3 — Replace `app/Actions/Posts/UpdatePost.php`

```php
<?php

namespace App\Actions\Posts;

use App\Actions\SEO\GenerateSlug;
use App\Models\Post;

class UpdatePost
{
    public function handle(Post $post, array $data): Post
    {
        $slug = $post->slug;

        if (isset($data['title']) && $data['title'] !== $post->title) {
            $slug = (new GenerateSlug())->handle($data['title'], 'posts');
        }

        $post->update([
            'title'             => $data['title'] ?? $post->title,
            'slug'              => $slug,
            'subtitle'          => $data['subtitle'] ?? $post->subtitle,
            'excerpt'           => $data['excerpt'] ?? $post->excerpt,
            'body'              => $data['body'] ?? $post->body,
            'status'            => $data['status'] ?? $post->status,
            'category_id'       => $data['category_id'] ?? $post->category_id,
            'featured_image_id' => $data['featured_image_id'] ?? $post->featured_image_id,
        ]);

        $post->tags()->sync($data['tags'] ?? []);

        return $post;
    }
}
```

### Step 3.4 — Replace `app/Actions/Posts/DeletePost.php`

```php
<?php

namespace App\Actions\Posts;

use App\Models\Post;

class DeletePost
{
    public function handle(Post $post): void
    {
        $post->delete();
    }
}
```

### Step 3.5 — Replace `app/Actions/Posts/PublishPost.php`

```php
<?php

namespace App\Actions\Posts;

use App\Models\Post;
use Illuminate\Support\Carbon;

class PublishPost
{
    public function handle(Post $post): void
    {
        $post->status       = 'published';
        $post->published_at = Carbon::now();
        $post->save();
    }
}
```

### Step 3.6 — Run tests

```bash
/c/MAMP/bin/php/php8.3.1/php.exe artisan test --filter=PostActionsTest
```

Expected: all tests pass.

### Step 3.7 — Commit

```bash
git add app/Actions/Posts/CreatePost.php app/Actions/Posts/UpdatePost.php \
        app/Actions/Posts/DeletePost.php app/Actions/Posts/PublishPost.php \
        tests/Feature/Actions/PostActionsTest.php
git commit -m "Implement CreatePost, UpdatePost, DeletePost, PublishPost actions with tests"
```

---

## Task 4: Jobs + SchedulePost + PostObserver

Create in this order: Job implementations first, then SchedulePost action, then PostObserver, then wire observer to Post model.

**Files to modify:**
- `app/Jobs/PublishScheduledPost.php`
- `app/Jobs/GenerateSeoSuggestions.php`
- `app/Actions/Posts/SchedulePost.php`
- `app/Observers/PostObserver.php`
- `app/Models/Post.php` (add `#[ObservedBy]`)

**Files to create:**
- `tests/Feature/Actions/SchedulePostTest.php`
- `tests/Feature/Jobs/PublishScheduledPostTest.php`

### Step 4.1 — Replace `app/Jobs/PublishScheduledPost.php`

```php
<?php

namespace App\Jobs;

use App\Actions\Posts\PublishPost;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishScheduledPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public readonly Post $post)
    {
    }

    public function handle(): void
    {
        // Re-check status — user may have changed it before the job fired
        $this->post->refresh();

        if ($this->post->status !== 'scheduled') {
            return;
        }

        (new PublishPost())->handle($this->post);
    }
}
```

### Step 4.2 — Replace `app/Jobs/GenerateSeoSuggestions.php`

```php
<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\PostMeta;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class GenerateSeoSuggestions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public readonly Post $post)
    {
    }

    public function handle(): void
    {
        $post = $this->post->load('tags');

        $metaDescription = Str::limit(
            $post->excerpt ?: strip_tags($post->body),
            160,
            ''
        );

        $focusKeyword = $post->tags->pluck('name')->join(', ');

        PostMeta::updateOrCreate(
            ['post_id' => $post->id],
            [
                'meta_description' => $metaDescription,
                'focus_keyword'    => $focusKeyword,
            ]
        );
    }
}
```

### Step 4.3 — Replace `app/Actions/Posts/SchedulePost.php`

```php
<?php

namespace App\Actions\Posts;

use App\Jobs\PublishScheduledPost;
use App\Models\Post;
use Illuminate\Support\Carbon;

class SchedulePost
{
    public function handle(Post $post, string $scheduledAt): void
    {
        $scheduledFor = Carbon::parse($scheduledAt);

        $post->status        = 'scheduled';
        $post->scheduled_for = $scheduledFor;
        $post->save();

        PublishScheduledPost::dispatch($post)->delay($scheduledFor);
    }
}
```

### Step 4.4 — Replace `app/Observers/PostObserver.php`

```php
<?php

namespace App\Observers;

use App\Jobs\GenerateSeoSuggestions;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostObserver
{
    public function created(Post $post): void
    {
        GenerateSeoSuggestions::dispatch($post);
    }

    public function updated(Post $post): void
    {
        GenerateSeoSuggestions::dispatch($post);
    }

    public function deleted(Post $post): void
    {
        DB::table('post_meta')->where('post_id', $post->id)->delete();
        DB::table('post_tags')->where('post_id', $post->id)->delete();
        DB::table('post_related')->where('post_id', $post->id)
            ->orWhere('related_post_id', $post->id)->delete();
        DB::table('post_internal_links')->where('post_id', $post->id)->delete();
        DB::table('post_faqs')->where('post_id', $post->id)->delete();
        DB::table('post_sources')->where('post_id', $post->id)->delete();
    }

    public function restored(Post $post): void
    {
        //
    }

    public function forceDeleted(Post $post): void
    {
        //
    }
}
```

### Step 4.5 — Update `app/Models/Post.php` to add `#[ObservedBy]`

Add to the top of `app/Models/Post.php` (add the import and attribute):

```php
<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'published_at'  => 'datetime',
        'scheduled_for' => 'datetime',
        'faq'           => 'array',
        'sources'       => 'array',
        'key_facts'     => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function meta()
    {
        return $this->hasOne(PostMeta::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
```

### Step 4.6 — Create `tests/Feature/Actions/SchedulePostTest.php`

```php
<?php

namespace Tests\Feature\Actions;

use App\Actions\Posts\SchedulePost;
use App\Jobs\PublishScheduledPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SchedulePostTest extends TestCase
{
    use RefreshDatabase;

    public function test_schedule_sets_status_scheduled_and_scheduled_for(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $post = Post::create([
            'title'   => 'Future Post',
            'slug'    => 'future-post',
            'body'    => '<p>Body</p>',
            'user_id' => $user->id,
            'status'  => 'draft',
        ]);

        $scheduledAt = now()->addDays(3)->toDateTimeString();

        (new SchedulePost())->handle($post, $scheduledAt);

        $post->refresh();
        $this->assertSame('scheduled', $post->status);
        $this->assertNotNull($post->scheduled_for);
    }

    public function test_schedule_dispatches_publish_scheduled_post_job(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $post = Post::create([
            'title'   => 'Future Post',
            'slug'    => 'future-post',
            'body'    => '<p>Body</p>',
            'user_id' => $user->id,
            'status'  => 'draft',
        ]);

        (new SchedulePost())->handle($post, now()->addDays(1)->toDateTimeString());

        Queue::assertPushed(PublishScheduledPost::class, function ($job) use ($post) {
            return $job->post->id === $post->id;
        });
    }
}
```

### Step 4.7 — Create `tests/Feature/Jobs/PublishScheduledPostTest.php`

```php
<?php

namespace Tests\Feature\Jobs;

use App\Jobs\PublishScheduledPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PublishScheduledPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_publishes_a_scheduled_post(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $post = Post::create([
            'title'        => 'Scheduled Post',
            'slug'         => 'scheduled-post',
            'body'         => '<p>Body</p>',
            'user_id'      => $user->id,
            'status'       => 'scheduled',
            'scheduled_for' => now()->subMinute(),
        ]);

        // Run the job directly (bypassing the queue)
        (new PublishScheduledPost($post))->handle();

        $post->refresh();
        $this->assertSame('published', $post->status);
        $this->assertNotNull($post->published_at);
    }

    public function test_job_skips_if_status_is_not_scheduled(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $post = Post::create([
            'title'   => 'Draft Post',
            'slug'    => 'draft-post',
            'body'    => '<p>Body</p>',
            'user_id' => $user->id,
            'status'  => 'draft',
        ]);

        (new PublishScheduledPost($post))->handle();

        $post->refresh();
        $this->assertSame('draft', $post->status);
        $this->assertNull($post->published_at);
    }
}
```

### Step 4.8 — Run tests

```bash
/c/MAMP/bin/php/php8.3.1/php.exe artisan test --filter=SchedulePostTest
/c/MAMP/bin/php/php8.3.1/php.exe artisan test --filter=PublishScheduledPostTest
```

Note: `PostActionsTest` may now fire `GenerateSeoSuggestions` via the observer because the observer is now attached to Post. The test already calls `Queue::fake()` in `setUp()`, so the job will be captured but not actually run. All existing tests should still pass.

Run full suite:

```bash
/c/MAMP/bin/php/php8.3.1/php.exe artisan test
```

### Step 4.9 — Commit

```bash
git add app/Jobs/PublishScheduledPost.php app/Jobs/GenerateSeoSuggestions.php \
        app/Actions/Posts/SchedulePost.php app/Observers/PostObserver.php \
        app/Models/Post.php \
        tests/Feature/Actions/SchedulePostTest.php \
        tests/Feature/Jobs/PublishScheduledPostTest.php
git commit -m "Implement PublishScheduledPost, GenerateSeoSuggestions jobs, SchedulePost action, PostObserver"
```

---

## Task 5: Post FormRequests + Full PostController + Routes

**Files to create:**
- `app/Http/Requests/Admin/StorePostRequest.php`
- `app/Http/Requests/Admin/UpdatePostRequest.php`

**Files to modify:**
- `app/Http/Controllers/Admin/PostController.php`
- `routes/admin.php`

No tests in this task — views are not yet wired; feature tests come in Task 9.

### Step 5.1 — Create `app/Http/Requests/Admin/StorePostRequest.php`

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'             => ['required', 'string', 'max:255'],
            'body'              => ['required', 'string'],
            'category_id'       => ['required', 'exists:categories,id'],
            'tags'              => ['nullable', 'array'],
            'tags.*'            => ['exists:tags,id'],
            'featured_image_id' => ['nullable', 'exists:media,id'],
            'status'            => ['nullable', 'in:draft,published,scheduled'],
            'excerpt'           => ['nullable', 'string', 'max:500'],
            'subtitle'          => ['nullable', 'string', 'max:255'],
        ];
    }
}
```

### Step 5.2 — Create `app/Http/Requests/Admin/UpdatePostRequest.php`

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'             => ['required', 'string', 'max:255'],
            'body'              => ['nullable', 'string'],
            'category_id'       => ['nullable', 'exists:categories,id'],
            'tags'              => ['nullable', 'array'],
            'tags.*'            => ['exists:tags,id'],
            'featured_image_id' => ['nullable', 'exists:media,id'],
            'status'            => ['nullable', 'in:draft,review,approved,scheduled,published,archived'],
            'excerpt'           => ['nullable', 'string', 'max:500'],
            'subtitle'          => ['nullable', 'string', 'max:255'],
        ];
    }
}
```

### Step 5.3 — Replace `app/Http/Controllers/Admin/PostController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Posts\CreatePost;
use App\Actions\Posts\DeletePost;
use App\Actions\Posts\PublishPost;
use App\Actions\Posts\SchedulePost;
use App\Actions\Posts\UpdatePost;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'meta'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $posts = $query->paginate(25)->withQueryString();

        $counts = [
            'all'       => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'draft'     => Post::where('status', 'draft')->count(),
            'review'    => Post::where('status', 'review')->count(),
            'scheduled' => Post::where('status', 'scheduled')->count(),
        ];

        $statusMeta = [
            'published' => ['label' => 'Published', 'bg' => 'var(--cms-green-soft)', 'color' => 'var(--cms-green-deep)'],
            'draft'     => ['label' => 'Draft',     'bg' => '#F0EDE8',               'color' => 'var(--cms-fg3)'],
            'review'    => ['label' => 'In Review', 'bg' => '#FFF6DD',               'color' => 'var(--cms-gold-deep)'],
            'scheduled' => ['label' => 'Scheduled', 'bg' => 'var(--cms-blue-soft)',  'color' => 'var(--cms-blue)'],
            'approved'  => ['label' => 'Approved',  'bg' => 'var(--cms-green-soft)', 'color' => 'var(--cms-green-deep)'],
            'archived'  => ['label' => 'Archived',  'bg' => '#F0EDE8',               'color' => 'var(--cms-fg3)'],
            'trash'     => ['label' => 'Trash',     'bg' => 'var(--cms-red-soft)',   'color' => 'var(--cms-red-deep)'],
        ];

        return view('admin.posts.index', compact('posts', 'counts', 'statusMeta'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();
        $users      = User::orderBy('name')->get();

        return view('admin.posts.create', compact('categories', 'tags', 'users'));
    }

    public function store(StorePostRequest $request)
    {
        $post = (new CreatePost())->handle($request->validated(), auth()->user());

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();
        $users      = User::orderBy('name')->get();

        $post->load(['tags', 'meta', 'category']);

        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'users'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        (new UpdatePost())->handle($post, $request->validated());

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        (new DeletePost())->handle($post);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post moved to trash.');
    }

    public function publish(Post $post)
    {
        (new PublishPost())->handle($post);

        return redirect()
            ->back()
            ->with('success', 'Post published successfully.');
    }

    public function schedule(Request $request, Post $post)
    {
        $request->validate([
            'scheduled_for' => ['required', 'date', 'after:now'],
        ]);

        (new SchedulePost())->handle($post, $request->scheduled_for);

        return redirect()
            ->back()
            ->with('success', 'Post scheduled successfully.');
    }
}
```

### Step 5.4 — Add publish and schedule routes to `routes/admin.php`

Inside the protected admin group, after the `Route::resource('posts', ...)` line, add:

```php
Route::post('posts/{post}/publish', [PostController::class, 'publish'])->name('posts.publish');
Route::post('posts/{post}/schedule', [PostController::class, 'schedule'])->name('posts.schedule');
```

The updated protected group section should look like:

```php
Route::resource('posts', PostController::class);
Route::post('posts/{post}/publish', [PostController::class, 'publish'])->name('posts.publish');
Route::post('posts/{post}/schedule', [PostController::class, 'schedule'])->name('posts.schedule');
Route::resource('categories', CategoryController::class);
Route::resource('tags', TagController::class);
```

### Step 5.5 — Commit

```bash
git add app/Http/Requests/Admin/StorePostRequest.php \
        app/Http/Requests/Admin/UpdatePostRequest.php \
        app/Http/Controllers/Admin/PostController.php \
        routes/admin.php
git commit -m "Implement full PostController with FormRequests, publish/schedule actions, and extra routes"
```

---

## Task 6: Wire Post Views to Real Data

**Files to modify:**
- `resources/views/admin/posts/index.blade.php`
- `resources/views/admin/posts/create.blade.php`
- `resources/views/admin/posts/edit.blade.php`

### Step 6.1 — Update `resources/views/admin/posts/index.blade.php`

Replace lines 7–29 (the entire `@php` block containing fake `$posts` data and `$statusMeta` and `$counts`) with a single `@php` block that only keeps `$statusMeta`:

```blade
@php
    $statusMeta = [
        'published' => ['label'=>'Published', 'bg'=>'var(--cms-green-soft)', 'color'=>'var(--cms-green-deep)'],
        'draft'     => ['label'=>'Draft',     'bg'=>'#F0EDE8',              'color'=>'var(--cms-fg3)'],
        'review'    => ['label'=>'In Review', 'bg'=>'#FFF6DD',              'color'=>'var(--cms-gold-deep)'],
        'scheduled' => ['label'=>'Scheduled', 'bg'=>'var(--cms-blue-soft)', 'color'=>'var(--cms-blue)'],
        'approved'  => ['label'=>'Approved',  'bg'=>'var(--cms-green-soft)','color'=>'var(--cms-green-deep)'],
        'archived'  => ['label'=>'Archived',  'bg'=>'#F0EDE8',              'color'=>'var(--cms-fg3)'],
        'trash'     => ['label'=>'Trash',     'bg'=>'var(--cms-red-soft)',  'color'=>'var(--cms-red-deep)'],
    ];
@endphp
```

(`$posts`, `$counts`, and `$statusMeta` are now passed from the controller — `$statusMeta` is re-declared here for the template to remain self-describing.)

Then update the `@foreach` loop and all references inside `tbody`. The current line 134 is:

```blade
@foreach($posts as $i => $post)
    @php $sm = $statusMeta[$post['status']]; @endphp
```

Change to:

```blade
@foreach($posts as $post)
    @php $sm = $statusMeta[$post->status] ?? $statusMeta['draft']; @endphp
```

Change line 137 (border trick):

```blade
style="border-bottom: {{ $i < count($posts)-1 ? '1px solid var(--cms-border)' : 'none' }};
```

Change to:

```blade
style="border-bottom: {{ !$loop->last ? '1px solid var(--cms-border)' : 'none' }};
```

Replace all `$post['key']` accesses inside the loop with property access:

| Old | New |
|-----|-----|
| `$post['id']` | `$post->id` |
| `$post['title']` | `$post->title` |
| `$post['status']` | `$post->status` |
| `$post['category']` | `$post->category?->name ?? '—'` |
| `$post['author']` | `$post->user->name` |
| `$post['views']` | `number_format($post->view_count)` |
| `$post['date']` | `$post->created_at->format('M j, Y')` |

For the SEO score column (lines 204–213), replace the block that references `$post['seo']` with a static dash since SEO score is not in the schema:

```blade
{{-- SEO Score --}}
<td style="padding: 14px 16px 14px 0; text-align: center;">
    <span style="font-size: 13px; color: var(--cms-fg4);">—</span>
</td>
```

For the author initials display (line 177), the `$post['author']` string operations become:

```blade
{{ strtoupper(substr($post->user->name, 0, 1) . (strrchr($post->user->name, ' ') ? substr(strrchr($post->user->name, ' '), 1, 1) : '')) }}
```

And the author name span:

```blade
<span style="font-size: 13px; color: var(--cms-fg2);">{{ $post->user->name }}</span>
```

For the status badge comparisons (lines 186–191), change `$post['status']` to `$post->status`:

```blade
@if($post->status === 'published')
    <span style="width: 6px; height: 6px; border-radius: 999px; background: var(--cms-green); display: inline-block;"></span>
@elseif($post->status === 'scheduled')
    <i data-lucide="clock" style="width: 11px; height: 11px;"></i>
@elseif($post->status === 'review')
    <i data-lucide="eye" style="width: 11px; height: 11px;"></i>
@endif
```

Replace the hardcoded pagination text:

```blade
<span style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3);">Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }} posts</span>
```

Replace the hardcoded page buttons with the Laravel paginator:

```blade
{{ $posts->links() }}
```

(Or keep the custom pagination UI and pass `$posts->links()` inside the existing pagination container — simplest approach is to replace the whole pagination `<div>` with the above line for now.)

### Step 6.2 — Update `resources/views/admin/posts/create.blade.php`

Remove lines 7–10 (the `@php $categories = [...]; $authors = [...]; @endphp` block entirely).

In the Author dropdown section (around line 189–193), change:

```blade
@foreach($authors as $a)
    <option value="{{ $a }}">{{ $a }}</option>
@endforeach
```

To:

```blade
@foreach($users as $u)
    <option value="{{ $u->id }}">{{ $u->name }}</option>
@endforeach
```

In the Category radio section (around line 246–251), change:

```blade
@foreach($categories as $cat)
    <label ...>
        <input type="radio" name="category" value="{{ $cat }}" ... />
        {{ $cat }}
    </label>
@endforeach
```

To:

```blade
@foreach($categories as $cat)
    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg2);">
        <input type="radio" name="category_id" value="{{ $cat->id }}" style="accent-color: var(--cms-gold); width: 15px; height: 15px; cursor: pointer;" />
        {{ $cat->name }}
    </label>
@endforeach
```

Also update the Tags section — the current implementation uses free-text tags. Since we now have a tags Eloquent collection passed from the controller, replace the hidden input and JS tag management with checkboxes. Replace the Tags card body (inside the `<div style="padding: 14px 16px;">` of the Tags panel) with:

```blade
<div style="display: flex; flex-direction: column; gap: 6px; max-height: 200px; overflow-y: auto;">
    @foreach($tags as $tag)
        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg2);">
            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                   style="accent-color: var(--cms-gold); width: 15px; height: 15px; cursor: pointer;" />
            {{ $tag->name }}
        </label>
    @endforeach
</div>
```

### Step 6.3 — Update `resources/views/admin/posts/edit.blade.php`

Replace the entire `@php` block (lines 7–30) which declares both a fake `$post` array and fake `$categories`/`$authors` arrays. Replace with nothing — the controller now passes a real `$post` Eloquent model, `$categories`, `$tags`, and `$users`.

Then update every reference in the view from `$post['key']` to `$post->key`:

| Old array access | New property access |
|------------------|---------------------|
| `$post['id']` | `$post->id` |
| `$post['title']` | `$post->title` |
| `$post['slug']` | `$post->slug` |
| `$post['subtitle'] ?? ''` | `$post->subtitle ?? ''` |
| `$post['excerpt']` | `$post->excerpt ?? ''` |
| `$post['body']` | `$post->body` |
| `$post['meta_title']` | `$post->meta?->seo_title ?? ''` |
| `$post['meta_desc']` | `$post->meta?->meta_description ?? ''` |
| `$post['status']` | `$post->status` |
| `$post['visibility']` | `$post->visibility ?? 'public'` |
| `$post['featured_img']` | `$post->featuredImage?->url ?? null` |
| `$post['scheduled_for'] ?? ''` | `$post->scheduled_for?->format('Y-m-d\TH:i') ?? ''` |
| `$post['seo_score']` | `0` (not in schema, remove the SEO score strip or hardcode `—`) |

For the form action, change:

```blade
action="{{ route('admin.posts.update', $post['id']) }}"
```

To:

```blade
action="{{ route('admin.posts.update', $post->id) }}"
```

For status `selected` comparisons (lines 200–205), change `$post['status']` to `$post->status`:

```blade
<option value="draft"     {{ $post->status === 'draft'     ? 'selected' : '' }}>Draft</option>
<option value="review"    {{ $post->status === 'review'    ? 'selected' : '' }}>In Review</option>
<option value="approved"  {{ $post->status === 'approved'  ? 'selected' : '' }}>Approved</option>
<option value="scheduled" {{ $post->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
<option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>Published</option>
<option value="archived"  {{ $post->status === 'archived'  ? 'selected' : '' }}>Archived</option>
```

For `visibility` `selected` comparisons, change `$post['visibility']` to `$post->visibility ?? 'public'`.

For the schedule-row display (line 208), change:

```blade
style="display: {{ $post['status']==='scheduled' ? 'block' : 'none' }};"
```

To:

```blade
style="display: {{ $post->status === 'scheduled' ? 'block' : 'none' }};"
```

For the scheduled_for input value (line 210), change:

```blade
value="{{ $post['scheduled_for'] ?? '' }}"
```

To:

```blade
value="{{ $post->scheduled_for?->format('Y-m-d\TH:i') ?? '' }}"
```

For the Author dropdown (lines 224–227), change:

```blade
@foreach($authors as $a)
    <option value="{{ $a }}" {{ $post['author']===$a ? 'selected':'' }}>{{ $a }}</option>
@endforeach
```

To:

```blade
@foreach($users as $u)
    <option value="{{ $u->id }}" {{ $post->user_id === $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
@endforeach
```

For the Category radio section (lines 280–286), change:

```blade
@foreach($categories as $cat)
    <label ...>
        <input type="radio" name="category" value="{{ $cat }}" {{ $post['category']===$cat ? 'checked':'' }} ... />
        {{ $cat }}
    </label>
@endforeach
```

To:

```blade
@foreach($categories as $cat)
    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg2);">
        <input type="radio" name="category_id" value="{{ $cat->id }}"
               {{ $post->category_id === $cat->id ? 'checked' : '' }}
               style="accent-color: var(--cms-gold); width: 15px; height: 15px; cursor: pointer;" />
        {{ $cat->name }}
    </label>
@endforeach
```

For the Tags section (lines 295–306), replace the JS-powered tags UI with checkboxes pre-checked for the post's existing tags:

```blade
<div style="padding: 14px 16px; display: flex; flex-direction: column; gap: 6px; max-height: 200px; overflow-y: auto;">
    @foreach($tags as $tag)
        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg2);">
            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                   {{ $post->tags->contains($tag->id) ? 'checked' : '' }}
                   style="accent-color: var(--cms-gold); width: 15px; height: 15px; cursor: pointer;" />
            {{ $tag->name }}
        </label>
    @endforeach
</div>
```

For the breadcrumb title display (line 41), change `$post['title']` to `$post->title`:

```blade
<span ...>{{ $post->title }}</span>
```

For the SEO score strip (lines 44–48), since SEO score is not in schema, remove those lines or replace with a placeholder:

```blade
<div style="display: flex; align-items: center; gap: 7px; padding: 5px 13px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md);">
    <i data-lucide="search" style="width: 14px; height: 14px; color: var(--cms-fg4);"></i>
    <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; color: var(--cms-fg4);">SEO —</span>
</div>
```

For the SERP preview section (lines 179–181), change:

```blade
<div ... id="serp-title">{{ $post['meta_title'] ?: $post['title'] }}</div>
<div ...>debesties.com › <span id="serp-slug">{{ $post['slug'] }}</span></div>
<div ... id="serp-desc">{{ $post['meta_desc'] ?: $post['excerpt'] }}</div>
```

To:

```blade
<div ... id="serp-title">{{ $post->meta?->seo_title ?: $post->title }}</div>
<div ...>debesties.com › <span id="serp-slug">{{ $post->slug }}</span></div>
<div ... id="serp-desc">{{ $post->meta?->meta_description ?: ($post->excerpt ?? '') }}</div>
```

For the JS at the bottom of edit.blade.php (line 325), change the pre-loaded tags from array of strings to array of IDs:

```blade
let tags = @json($post->tags->pluck('id')->toArray());
```

(But since we switched tags to checkboxes, this JS line and the `renderTags()` call and the entire tag JS section can be removed entirely — checkboxes handle the state.)

For the excerpt count display (line 91), change:

```blade
{{ strlen($post['excerpt']) }}
```

To:

```blade
{{ strlen($post->excerpt ?? '') }}
```

For the excerpt textarea (line 93–95), change:

```blade
>{{ $post['excerpt'] }}</textarea>
```

To:

```blade
>{{ $post->excerpt ?? '' }}</textarea>
```

For the body content in the contenteditable div (line 142), change:

```blade
>{!! $post['body'] !!}</div>
```

To:

```blade
>{!! $post->body !!}</div>
```

For the meta_title input value (line 160), change:

```blade
value="{{ $post['meta_title'] }}"
```

To:

```blade
value="{{ $post->meta?->seo_title ?? '' }}"
```

For seo-title-count (line 166), change:

```blade
>{{ strlen($post['meta_title']) }}</span>
```

To:

```blade
>{{ strlen($post->meta?->seo_title ?? '') }}</span>
```

For meta_description textarea (line 175), change:

```blade
>{{ $post['meta_desc'] }}</textarea>
```

To:

```blade
>{{ $post->meta?->meta_description ?? '' }}</textarea>
```

### Step 6.4 — Commit

```bash
git add resources/views/admin/posts/index.blade.php \
        resources/views/admin/posts/create.blade.php \
        resources/views/admin/posts/edit.blade.php
git commit -m "Wire post views to real Eloquent data, replace fake arrays, fix form field names"
```

---

## Task 7: Category FormRequests + Full CategoryController

**Files to create:**
- `app/Http/Requests/Admin/StoreCategoryRequest.php`
- `app/Http/Requests/Admin/UpdateCategoryRequest.php`

**Files to modify:**
- `app/Http/Controllers/Admin/CategoryController.php`

### Step 7.1 — Create `app/Http/Requests/Admin/StoreCategoryRequest.php`

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:100'],
            'parent_id'   => ['nullable', 'exists:categories,id'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_visible'  => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
```

### Step 7.2 — Create `app/Http/Requests/Admin/UpdateCategoryRequest.php`

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:100'],
            'parent_id'   => ['nullable', 'exists:categories,id'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_visible'  => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
```

### Step 7.3 — Replace `app/Http/Controllers/Admin/CategoryController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SEO\GenerateSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['parent', 'children'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(50);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->orderBy('name')->get();

        return view('admin.categories.create', compact('parents'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $slug = (new GenerateSlug())->handle($request->name, 'categories');

        Category::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'description' => $request->description,
            'parent_id'   => $request->parent_id,
            'sort_order'  => $request->sort_order ?? 0,
            'is_visible'  => $request->boolean('is_visible', true),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $slug = $category->slug;

        if ($request->name !== $category->name) {
            $slug = (new GenerateSlug())->handle($request->name, 'categories');
        }

        $category->update([
            'name'        => $request->name,
            'slug'        => $slug,
            'description' => $request->description,
            'parent_id'   => $request->parent_id,
            'sort_order'  => $request->sort_order ?? 0,
            'is_visible'  => $request->boolean('is_visible', true),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->count() > 0) {
            return redirect()
                ->back()
                ->withErrors(['category' => 'Cannot delete a category that has posts assigned to it.']);
        }

        // Reassign children to the category's parent (or null if top-level)
        $category->children()->update(['parent_id' => $category->parent_id]);

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted.');
    }
}
```

### Step 7.4 — Commit

```bash
git add app/Http/Requests/Admin/StoreCategoryRequest.php \
        app/Http/Requests/Admin/UpdateCategoryRequest.php \
        app/Http/Controllers/Admin/CategoryController.php
git commit -m "Implement full CategoryController with FormRequests, GenerateSlug, destroy guard"
```

---

## Task 8: Wire Category + Tag Views + Tag FormRequests + TagController

**Files to create:**
- `app/Http/Requests/Admin/StoreTagRequest.php`
- `app/Http/Requests/Admin/UpdateTagRequest.php`

**Files to modify:**
- `app/Http/Controllers/Admin/TagController.php`
- `resources/views/admin/categories/index.blade.php`
- `resources/views/admin/tags/index.blade.php`

### Step 8.1 — Create `app/Http/Requests/Admin/StoreTagRequest.php`

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
        ];
    }
}
```

### Step 8.2 — Create `app/Http/Requests/Admin/UpdateTagRequest.php`

```php
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
        ];
    }
}
```

### Step 8.3 — Replace `app/Http/Controllers/Admin/TagController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SEO\GenerateSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTagRequest;
use App\Http\Requests\Admin\UpdateTagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('posts')
            ->orderBy('name')
            ->paginate(50);

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(StoreTagRequest $request)
    {
        $slug = (new GenerateSlug())->handle($request->name, 'tags');

        Tag::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag created successfully.');
    }

    public function show(Tag $tag)
    {
        return view('admin.tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $slug = (new GenerateSlug())->handle($request->name, 'tags');

        $tag->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $tag->posts()->detach();
        $tag->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag deleted.');
    }
}
```

### Step 8.4 — Wire `resources/views/admin/categories/index.blade.php`

Remove the `@php` block on lines 7–23 (which declares fake `$categories`, `$topLevel`, and `$children` arrays).

The controller now passes a paginated `$categories` Eloquent collection (with `parent` and `children` loaded). Update the view accordingly:

Replace the `count($categories)` reference (line 34):

```blade
<span ...>{{ $categories->total() }} total</span>
```

Replace the top-level categories loop and nested children loop. The current structure iterates `$topLevel` then nested `$children`. With Eloquent, use:

```blade
{{-- Top-level categories --}}
@foreach($categories as $cat)
    <tr style="border-bottom: 1px solid var(--cms-border); transition: background 100ms;"
        onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
        <td style="padding: 13px 16px; text-align: center;">
            <input type="checkbox" class="cat-cb" value="{{ $cat->id }}" onchange="updateBulk()" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
        </td>
        <td style="padding: 13px 16px 13px 0;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 7px; height: 7px; border-radius: 999px; background: var(--cms-gold); flex-shrink: 0;"></div>
                <span style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);">{{ $cat->name }}</span>
            </div>
        </td>
        <td style="padding: 13px 16px 13px 0;">
            <span style="font-family: var(--cms-font-mono); font-size: 12px; color: var(--cms-fg3);">{{ $cat->slug }}</span>
        </td>
        <td style="padding: 13px 16px 13px 0;">
            <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg4);">—</span>
        </td>
        <td style="padding: 13px 16px 13px 0; text-align: center;">
            <a href="{{ route('admin.posts.index', ['category' => $cat->slug]) }}"
               style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; color: var(--cms-blue); text-decoration: none;">
                {{ $cat->posts_count ?? $cat->posts()->count() }}
            </a>
        </td>
        <td style="padding: 13px 16px 13px 0; text-align: center;">
            <button onclick="toggleVisible({{ $cat->id }}, this)"
                    data-visible="{{ $cat->is_visible ? 'true' : 'false' }}"
                    style="width: 38px; height: 22px; border-radius: 999px; border: none; cursor: pointer; transition: background 200ms; position: relative; background: {{ $cat->is_visible ? 'var(--cms-green)' : 'var(--cms-border-st)' }};">
                <span style="position: absolute; top: 3px; width: 16px; height: 16px; border-radius: 999px; background: #fff; transition: left 200ms; left: {{ $cat->is_visible ? '19px' : '3px' }};"></span>
            </button>
        </td>
        <td style="padding: 13px 16px;">
            <div style="display: flex; gap: 5px; justify-content: flex-end;">
                <a href="{{ route('admin.categories.edit', $cat->id) }}" title="Edit"
                   style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3); text-decoration: none;"
                   onmouseover="this.style.background='var(--cms-bg)'; this.style.color='var(--cms-fg1)'"
                   onmouseout="this.style.background='var(--cms-surface)'; this.style.color='var(--cms-fg3)'">
                    <i data-lucide="edit-2" style="width: 13px; height: 13px;"></i>
                </a>
                <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}" style="display: inline;">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete {{ $cat->name }}?')" title="Delete"
                            style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(200,55,43,0.2); background: var(--cms-red-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red);"
                            onmouseover="this.style.background='#F8D5D2'" onmouseout="this.style.background='var(--cms-red-soft)'">
                        <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>

    {{-- Children --}}
    @foreach($cat->children as $child)
        <tr style="border-bottom: 1px solid var(--cms-border); background: #FDFBF8; transition: background 100ms;"
            onmouseover="this.style.background='#FAF7F2'" onmouseout="this.style.background='#FDFBF8'">
            <td style="padding: 10px 16px; text-align: center;">
                <input type="checkbox" class="cat-cb" value="{{ $child->id }}" onchange="updateBulk()" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
            </td>
            <td style="padding: 10px 16px 10px 0;">
                <div style="display: flex; align-items: center; gap: 8px; padding-left: 20px;">
                    <i data-lucide="corner-down-right" style="width: 13px; height: 13px; color: var(--cms-fg4);"></i>
                    <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 500; color: var(--cms-fg2);">{{ $child->name }}</span>
                </div>
            </td>
            <td style="padding: 10px 16px 10px 0;">
                <span style="font-family: var(--cms-font-mono); font-size: 11.5px; color: var(--cms-fg4);">{{ $child->slug }}</span>
            </td>
            <td style="padding: 10px 16px 10px 0;">
                <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg3);">{{ $cat->name }}</span>
            </td>
            <td style="padding: 10px 16px 10px 0; text-align: center;">
                <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; color: var(--cms-fg2);">{{ $child->posts()->count() }}</span>
            </td>
            <td style="padding: 10px 16px 10px 0; text-align: center;">
                <button onclick="toggleVisible({{ $child->id }}, this)" data-visible="{{ $child->is_visible ? 'true' : 'false' }}"
                        style="width: 38px; height: 22px; border-radius: 999px; border: none; cursor: pointer; background: {{ $child->is_visible ? 'var(--cms-green)' : 'var(--cms-border-st)' }}; position: relative; transition: background 200ms;">
                    <span style="position: absolute; top: 3px; width: 16px; height: 16px; border-radius: 999px; background: #fff; transition: left 200ms; left: {{ $child->is_visible ? '19px' : '3px' }};"></span>
                </button>
            </td>
            <td style="padding: 10px 16px;">
                <div style="display: flex; gap: 5px; justify-content: flex-end;">
                    <a href="{{ route('admin.categories.edit', $child->id) }}"
                       style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3); text-decoration: none;"
                       onmouseover="this.style.background='var(--cms-bg)'" onmouseout="this.style.background='var(--cms-surface)'">
                        <i data-lucide="edit-2" style="width: 13px; height: 13px;"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $child->id) }}" style="display: inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete {{ $child->name }}?')"
                                style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(200,55,43,0.2); background: var(--cms-red-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red);"
                                onmouseover="this.style.background='#F8D5D2'" onmouseout="this.style.background='var(--cms-red-soft)'">
                            <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
@endforeach
```

Also update the sidebar "Add Category" form: change it from a non-functional JS-only form to a proper POST form:

```blade
<form method="POST" action="{{ route('admin.categories.store') }}" style="padding: 18px; display: flex; flex-direction: column; gap: 14px;">
@csrf
```

And update the Parent Category select to use Eloquent IDs (the `$topLevel` variable is replaced by iterating `$categories->where('parent_id', null)` or pass a separate `$topLevel` variable from the controller — simplest: update the controller to also pass `$topLevel = Category::whereNull('parent_id')->orderBy('name')->get()` and reference it in the view):

Update `CategoryController::index()` to also pass `$topLevel`:

```php
public function index()
{
    $categories = Category::with(['parent', 'children'])
        ->orderBy('sort_order')
        ->orderBy('name')
        ->paginate(50);

    $topLevel = Category::whereNull('parent_id')->orderBy('name')->get();

    return view('admin.categories.index', compact('categories', 'topLevel'));
}
```

Then in the view's parent select:

```blade
<select id="cat-parent" name="parent_id" ...>
    <option value="">None (top-level)</option>
    @foreach($topLevel as $cat)
        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
    @endforeach
</select>
```

Add proper form inputs for all fields:

```blade
<input name="name" id="cat-name" type="text" ... />
<input name="slug" id="cat-slug" type="text" ... />  {{-- optional, controller auto-generates --}}
<textarea name="description" id="cat-desc" ...></textarea>
<input name="sort_order" id="cat-order" type="number" value="0" min="0" ... />
```

### Step 8.5 — Wire `resources/views/admin/tags/index.blade.php`

Remove lines 7–24 (the `@php $tags = [...]; $maxCount = ...` block).

The controller now passes `$tags` as a paginated Eloquent collection with `posts_count` loaded via `withCount('posts')`.

Replace `count($tags)` reference:

```blade
{{ $tags->total() }} tags total
```

Replace `$maxCount`:

```blade
@php $maxCount = $tags->max('posts_count') ?: 1; @endphp
```

(Add this at the top of the content section, or in a small `@php` block before the foreach loops.)

Replace the tag cloud `@foreach` loop to use Eloquent properties:

```blade
@foreach($tags as $tag)
    @php
        $ratio = $tag->posts_count / $maxCount;
        $size = 12 + ($ratio * 10);
        $opacity = 0.5 + ($ratio * 0.5);
    @endphp
    <button onclick="selectTag({{ $tag->id }}, '{{ $tag->name }}', '{{ $tag->slug }}')"
            data-tag-id="{{ $tag->id }}"
            data-tag-name="{{ strtolower($tag->name) }}"
            style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; background: rgba(232,168,0,{{ $opacity * 0.15 }}); color: var(--cms-gold-deep); border: 1.5px solid rgba(232,168,0,{{ $opacity * 0.4 }}); border-radius: 999px; font-family: var(--cms-font-ui); font-size: {{ $size }}px; font-weight: 600; cursor: pointer; transition: all 150ms;"
            onmouseover="this.style.background='var(--cms-gold-soft)'; this.style.borderColor='var(--cms-gold)'"
            onmouseout="this.style.background='rgba(232,168,0,{{ $opacity * 0.15 }})'; this.style.borderColor='rgba(232,168,0,{{ $opacity * 0.4 }})'">
        {{ $tag->name }}
        <span style="font-size: 11px; opacity: 0.7;">{{ $tag->posts_count }}</span>
    </button>
@endforeach
```

Replace the tags table `@foreach` loop — change from `$tag['key']` to `$tag->key` and fix the border logic:

```blade
@foreach($tags as $tag)
    <tr class="tag-row" data-name="{{ strtolower($tag->name) }}"
        style="border-bottom: {{ !$loop->last ? '1px solid var(--cms-border)' : 'none' }}; transition: background 100ms;"
        onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
        <td style="padding: 12px 16px; text-align: center;">
            <input type="checkbox" class="tag-cb" value="{{ $tag->id }}" onchange="updateBulk()" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
        </td>
        <td style="padding: 12px 16px 12px 0;">
            <div id="name-display-{{ $tag->id }}" style="display: flex; align-items: center; gap: 8px;">
                <span style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);">{{ $tag->name }}</span>
            </div>
            <input id="name-input-{{ $tag->id }}" type="text" value="{{ $tag->name }}"
                   style="display: none; width: 100%; height: 32px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-gold); border-radius: var(--cms-r-md); outline: none;"
                   onkeydown="if(event.key==='Enter') saveTag({{ $tag->id }}); if(event.key==='Escape') cancelEdit({{ $tag->id }});"
                   onblur="saveTag({{ $tag->id }})" />
        </td>
        <td style="padding: 12px 16px 12px 0;">
            <span style="font-family: var(--cms-font-mono); font-size: 12px; color: var(--cms-fg3);">{{ $tag->slug }}</span>
        </td>
        <td style="padding: 12px 16px 12px 0; text-align: center;">
            <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; color: var(--cms-fg2);">{{ $tag->posts_count }}</span>
        </td>
        <td style="padding: 12px 16px; text-align: right;">
            <div style="display: flex; gap: 6px; justify-content: flex-end;">
                <button onclick="editTag({{ $tag->id }})" title="Edit"
                        style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);"
                        onmouseover="this.style.background='var(--cms-bg)'; this.style.color='var(--cms-fg1)'"
                        onmouseout="this.style.background='var(--cms-surface)'; this.style.color='var(--cms-fg3)'">
                    <i data-lucide="edit-2" style="width: 13px; height: 13px;"></i>
                </button>
                <form method="POST" action="{{ route('admin.tags.destroy', $tag->id) }}" style="display: inline;">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete {{ $tag->name }}?')" title="Delete"
                            style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(200,55,43,0.2); background: var(--cms-red-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red);"
                            onmouseover="this.style.background='#F8D5D2'" onmouseout="this.style.background='var(--cms-red-soft)'">
                        <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
```

Update the "Add Tag" form to POST to the store route:

```blade
<form id="tag-form" method="POST" action="{{ route('admin.tags.store') }}" style="padding: 18px; display: flex; flex-direction: column; gap: 14px;">
@csrf
<input type="hidden" id="edit-tag-id" value="" />
<div>
    <label ...>Name</label>
    <input name="name" id="new-tag-name" type="text" placeholder="e.g. Afrobeats" oninput="autoSlug(this.value)" ... />
</div>
...
```

### Step 8.6 — Commit

```bash
git add app/Http/Requests/Admin/StoreTagRequest.php \
        app/Http/Requests/Admin/UpdateTagRequest.php \
        app/Http/Controllers/Admin/TagController.php \
        resources/views/admin/categories/index.blade.php \
        resources/views/admin/tags/index.blade.php
git commit -m "Implement TagController with FormRequests, wire category and tag views to real Eloquent data"
```

---

## Task 9: Post CRUD Feature Tests

**File to create:**
- `tests/Feature/Posts/PostCrudTest.php`

### Step 9.1 — Create `tests/Feature/Posts/PostCrudTest.php`

```php
<?php

namespace Tests\Feature\Posts;

use App\Jobs\PublishScheduledPost;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostMeta;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PostCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $role        = Role::create(['name' => 'Super Admin', 'slug' => 'super_admin']);
        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($role);

        $this->category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
    }

    public function test_admin_can_view_posts_list(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.posts.index'))
            ->assertStatus(200);
    }

    public function test_admin_can_create_a_post(): void
    {
        Queue::fake();

        $tag = Tag::create(['name' => 'PHP', 'slug' => 'php']);

        $response = $this->actingAs($this->admin)->post(route('admin.posts.store'), [
            'title'       => 'Test Post Title',
            'body'        => '<p>Post body content</p>',
            'category_id' => $this->category->id,
            'tags'        => [$tag->id],
            'status'      => 'draft',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title',
            'slug'  => 'test-post-title',
            'status' => 'draft',
        ]);

        $post = Post::where('title', 'Test Post Title')->first();
        $this->assertDatabaseHas('post_meta', ['post_id' => $post->id]);
        $this->assertDatabaseHas('post_tags', ['post_id' => $post->id, 'tag_id' => $tag->id]);
    }

    public function test_admin_can_update_post_and_slug_changes_on_title_change(): void
    {
        Queue::fake();

        $post = Post::create([
            'title'   => 'Original Title',
            'slug'    => 'original-title',
            'body'    => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'status'  => 'draft',
        ]);
        PostMeta::create(['post_id' => $post->id]);

        $this->actingAs($this->admin)->put(route('admin.posts.update', $post), [
            'title'       => 'Updated Title',
            'body'        => '<p>Updated body</p>',
            'category_id' => $this->category->id,
        ]);

        $this->assertDatabaseHas('posts', [
            'id'    => $post->id,
            'title' => 'Updated Title',
            'slug'  => 'updated-title',
        ]);
    }

    public function test_slug_not_regenerated_when_title_unchanged(): void
    {
        Queue::fake();

        $post = Post::create([
            'title'   => 'Same Title',
            'slug'    => 'same-title',
            'body'    => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'status'  => 'draft',
        ]);
        PostMeta::create(['post_id' => $post->id]);

        $this->actingAs($this->admin)->put(route('admin.posts.update', $post), [
            'title'       => 'Same Title',
            'body'        => '<p>Different body</p>',
            'category_id' => $this->category->id,
        ]);

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'slug' => 'same-title']);
    }

    public function test_admin_can_soft_delete_post(): void
    {
        Queue::fake();

        $post = Post::create([
            'title'   => 'To Be Deleted',
            'slug'    => 'to-be-deleted',
            'body'    => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'status'  => 'draft',
        ]);

        $this->actingAs($this->admin)
            ->delete(route('admin.posts.destroy', $post));

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    public function test_admin_can_publish_post(): void
    {
        Queue::fake();

        $post = Post::create([
            'title'   => 'To Be Published',
            'slug'    => 'to-be-published',
            'body'    => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'status'  => 'draft',
        ]);

        $this->actingAs($this->admin)
            ->post(route('admin.posts.publish', $post));

        $post->refresh();
        $this->assertSame('published', $post->status);
        $this->assertNotNull($post->published_at);
    }

    public function test_admin_can_schedule_post(): void
    {
        Queue::fake();

        $post = Post::create([
            'title'   => 'To Be Scheduled',
            'slug'    => 'to-be-scheduled',
            'body'    => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'status'  => 'draft',
        ]);

        $scheduledFor = now()->addDays(2)->format('Y-m-d H:i:s');

        $this->actingAs($this->admin)->post(route('admin.posts.schedule', $post), [
            'scheduled_for' => $scheduledFor,
        ]);

        $post->refresh();
        $this->assertSame('scheduled', $post->status);
        $this->assertNotNull($post->scheduled_for);

        Queue::assertPushed(PublishScheduledPost::class, function ($job) use ($post) {
            return $job->post->id === $post->id;
        });
    }

    public function test_unauthenticated_user_redirected_to_admin_login(): void
    {
        $this->get(route('admin.posts.index'))
            ->assertRedirect(route('admin.login'));
    }
}
```

### Step 9.2 — Run tests

```bash
/c/MAMP/bin/php/php8.3.1/php.exe artisan test --filter=PostCrudTest
```

### Step 9.3 — Commit

```bash
git add tests/Feature/Posts/PostCrudTest.php
git commit -m "Add PostCrudTest feature tests covering CRUD, publish, schedule, and auth guard"
```

---

## Task 10: Category + Tag Feature Tests

**Files to create:**
- `tests/Feature/Posts/CategoryCrudTest.php`
- `tests/Feature/Posts/TagCrudTest.php`

### Step 10.1 — Create `tests/Feature/Posts/CategoryCrudTest.php`

```php
<?php

namespace Tests\Feature\Posts;

use App\Models\Category;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role        = Role::create(['name' => 'Super Admin', 'slug' => 'super_admin']);
        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($role);
    }

    public function test_admin_can_create_category_with_auto_slug(): void
    {
        $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name'       => 'Music Awards',
            'sort_order' => 1,
            'is_visible' => true,
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Music Awards',
            'slug' => 'music-awards',
        ]);
    }

    public function test_cannot_delete_category_that_has_posts(): void
    {
        Queue::fake();

        $category = Category::create(['name' => 'Busy Cat', 'slug' => 'busy-cat']);

        Post::create([
            'title'       => 'A Post',
            'slug'        => 'a-post',
            'body'        => '<p>Body</p>',
            'user_id'     => $this->admin->id,
            'category_id' => $category->id,
            'status'      => 'draft',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.categories.destroy', $category));

        $response->assertSessionHasErrors('category');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_deleting_category_reassigns_children_to_grandparent(): void
    {
        $grandparent = Category::create(['name' => 'Top Level', 'slug' => 'top-level']);
        $parent      = Category::create(['name' => 'Middle', 'slug' => 'middle', 'parent_id' => $grandparent->id]);
        $child       = Category::create(['name' => 'Leaf', 'slug' => 'leaf', 'parent_id' => $parent->id]);

        $this->actingAs($this->admin)
            ->delete(route('admin.categories.destroy', $parent));

        $child->refresh();
        $this->assertSame($grandparent->id, $child->parent_id);
        $this->assertSoftDeleted('categories', ['id' => $parent->id]);
    }
}
```

### Step 10.2 — Create `tests/Feature/Posts/TagCrudTest.php`

```php
<?php

namespace Tests\Feature\Posts;

use App\Models\Post;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class TagCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role        = Role::create(['name' => 'Super Admin', 'slug' => 'super_admin']);
        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($role);
    }

    public function test_admin_can_create_tag_with_auto_slug(): void
    {
        $this->actingAs($this->admin)->post(route('admin.tags.store'), [
            'name' => 'Ghana Music',
        ]);

        $this->assertDatabaseHas('tags', [
            'name' => 'Ghana Music',
            'slug' => 'ghana-music',
        ]);
    }

    public function test_admin_can_update_tag_and_slug_regenerates(): void
    {
        $tag = Tag::create(['name' => 'Old Name', 'slug' => 'old-name']);

        $this->actingAs($this->admin)->put(route('admin.tags.update', $tag), [
            'name' => 'New Name',
        ]);

        $this->assertDatabaseHas('tags', [
            'id'   => $tag->id,
            'name' => 'New Name',
            'slug' => 'new-name',
        ]);
    }

    public function test_admin_can_delete_tag_and_pivot_rows_removed(): void
    {
        Queue::fake();

        $tag  = Tag::create(['name' => 'To Delete', 'slug' => 'to-delete']);
        $post = Post::create([
            'title'   => 'Tagged Post',
            'slug'    => 'tagged-post',
            'body'    => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'status'  => 'draft',
        ]);
        $post->tags()->attach($tag->id);

        $this->assertDatabaseHas('post_tags', ['tag_id' => $tag->id, 'post_id' => $post->id]);

        $this->actingAs($this->admin)
            ->delete(route('admin.tags.destroy', $tag));

        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
        $this->assertDatabaseMissing('post_tags', ['tag_id' => $tag->id]);
    }
}
```

### Step 10.3 — Run full test suite

```bash
/c/MAMP/bin/php/php8.3.1/php.exe artisan test
```

All tests should pass. If any test fails, investigate before committing.

### Step 10.4 — Commit

```bash
git add tests/Feature/Posts/CategoryCrudTest.php tests/Feature/Posts/TagCrudTest.php
git commit -m "Add CategoryCrudTest and TagCrudTest feature tests"
```

---

## Completion Checklist

- [ ] Task 1: GenerateSlug action implemented and tested
- [ ] Task 2: Post, PostMeta, Category, Tag models fixed
- [ ] Task 3: CreatePost, UpdatePost, DeletePost, PublishPost actions + PostActionsTest
- [ ] Task 4: PublishScheduledPost, GenerateSeoSuggestions jobs, SchedulePost action, PostObserver, ObservedBy on Post model + tests
- [ ] Task 5: StorePostRequest, UpdatePostRequest, full PostController, publish/schedule routes
- [ ] Task 6: posts/index, posts/create, posts/edit views wired to real data
- [ ] Task 7: StoreCategoryRequest, UpdateCategoryRequest, full CategoryController
- [ ] Task 8: StoreTagRequest, UpdateTagRequest, full TagController, categories/index and tags/index views wired
- [ ] Task 9: PostCrudTest feature tests passing
- [ ] Task 10: CategoryCrudTest + TagCrudTest feature tests passing, full suite green

---

## Common Pitfalls

1. **`Queue::fake()` must be called before any Post create/update** (Tasks 3–10) because the `PostObserver` fires `GenerateSeoSuggestions::dispatch()` on every save. Without `Queue::fake()`, the job runs synchronously (queue is `sync` in tests) and will fail if the job tries to load relationships before they exist.

2. **Tag model has no SoftDeletes** — `assertSoftDeleted('tags', ...)` will fail. Use `assertDatabaseMissing` for tag deletion assertions.

3. **Category uses SoftDeletes** — `$category->delete()` is a soft delete. `assertDatabaseMissing` won't find the record if it's only soft deleted. Use `assertSoftDeleted` instead.

4. **`UpdatePost` with empty tags array** — `$post->tags()->sync([])` detaches all tags. If `tags` key is absent from `$data`, use `$data['tags'] ?? []` to avoid unintentionally clearing tags.

5. **`StorePostRequest` requires `category_id`** — but `Post::create()` in test factories doesn't require it. The FormRequest validation differs from direct model creation. Always bypass FormRequest in unit/action tests by calling the action directly.

6. **`GenerateSlug` checks the table for uniqueness** — when testing slug generation for `posts`, there must be a `posts` table (RefreshDatabase handles this). Ensure categories table is used in `GenerateSlugTest` since it requires fewer mandatory columns.
