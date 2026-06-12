<?php

namespace App\Providers;

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
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Media::observe(\App\Observers\MediaObserver::class);
        \App\Models\Post::observe(\App\Observers\PostObserver::class);
        \App\Models\Comment::observe(\App\Observers\CommentObserver::class);

        \Illuminate\Support\Facades\Gate::policy(\App\Models\Post::class, \App\Policies\PostPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Media::class, \App\Policies\MediaPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\User::class, \App\Policies\UserPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Comment::class, \App\Policies\CommentPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\NewsletterCampaign::class, \App\Policies\NewsletterCampaignPolicy::class);
    }
}
