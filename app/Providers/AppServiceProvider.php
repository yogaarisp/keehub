<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('access-admin', fn ($user) => in_array($user->role, ['owner', 'staff']));

        Gate::define('manage-settings', fn ($user) => $user->role === 'owner');

        Gate::define('manage-users', fn ($user) => $user->role === 'owner');
    }
}
