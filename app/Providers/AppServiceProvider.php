<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentIcon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production') || request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }

        Gate::define('access-admin', fn ($user) => in_array($user->role, ['owner', 'staff']));

        Gate::define('manage-settings', fn ($user) => $user->role === 'owner');

        Gate::define('manage-users', fn ($user) => $user->role === 'owner');

        FilamentIcon::register([
            'modal.close-button' => 'heroicon-o-arrow-left',
        ]);
    }
}
