<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\LogRepository;
use App\Implementations\Eloquent\LogImplementation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogRepository::class, LogImplementation::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
