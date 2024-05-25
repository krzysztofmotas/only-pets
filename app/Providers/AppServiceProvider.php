<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Policies\PostPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Post::class => PostPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        // $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('has-active-subscription', function (User $user, $id) {
            return $user->hasActiveSubscriptionFor($id);
        });

        Gate::define('is-active-subscriber', function (User $user, $id) {
            return $user->hasActiveSubscriptionFrom($id);
        });
    }
}
