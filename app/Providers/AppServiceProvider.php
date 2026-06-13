<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Category;
use App\Models\Media;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Post;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\User;
use App\Observers\CommentObserver;
use App\Observers\MediaObserver;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use App\Policies\CommentPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\MediaPolicy;
use App\Policies\MenuPolicy;
use App\Policies\PagePolicy;
use App\Policies\PostPolicy;
use App\Policies\RolePolicy;
use App\Policies\SettingPolicy;
use App\Policies\TagPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Media::observe(MediaObserver::class);
        Post::observe(PostObserver::class);
        Comment::observe(CommentObserver::class);

        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Page::class, PagePolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Tag::class, TagPolicy::class);
        Gate::policy(Media::class, MediaPolicy::class);
        Gate::policy(Menu::class, MenuPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Setting::class, SettingPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
    }
}
