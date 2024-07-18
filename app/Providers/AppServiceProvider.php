<?php

namespace App\Providers;

use App\Policies\TripPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
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
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Gate::define('create-trip', [TripPolicy::class, 'create']);
        Gate::define('participate-trip', [TripPolicy::class, 'participate']);
    }
}
