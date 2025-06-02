<?php

namespace App\Providers;

use App\Models\User;
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
        // Define your coordinator gate
        Gate::define('coord', function (User $user) {
            // Make sure the role relationship exists and is loaded
            return $user->role && $user->role->iscoordonnateur;
        });

        Gate::define('prof', function (User $user) {
            // Make sure the role relationship exists and is loaded
            return $user->role && $user->role->isprof;
        });
    }
}
