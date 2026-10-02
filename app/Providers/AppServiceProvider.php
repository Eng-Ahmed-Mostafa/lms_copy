<?php

namespace App\Providers;

use App\Models\Enrollment;
use App\Policies\Enrollment\EnrollmentPolicy;
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
        Gate::policy(Enrollment::class, EnrollmentPolicy::class);
    }
}
