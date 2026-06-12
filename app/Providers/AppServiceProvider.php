<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use App\Observers\CommentObserver;
use App\Observers\MediaObserver;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use App\Policies\CommentPolicy;
use App\Policies\MediaPolicy;
use App\Policies\PostPolicy;
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
        Gate::policy(Media::class, MediaPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
    }
}
