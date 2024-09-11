<?php

namespace App\Providers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
//use Illuminate\Support\ServiceProvider;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\User;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $policies = [
        Post::class => PostPolicy::class,
    ];

    public function register(): void
    {
      
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('update-post', function (User $user, Post $post) {
            return $user->id === $post->creator_id;
        });
    }
}
