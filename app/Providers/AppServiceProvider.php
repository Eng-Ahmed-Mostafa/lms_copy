<?php

namespace App\Providers;

use App\Models\Enrollment;
use App\Models\ExamAttempt;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Policies\Auth\PermissionPolicy;
use App\Policies\Auth\RolePolicy;
use App\Policies\Assessments\ExamAttemptPolicy;
use App\Policies\Enrollment\EnrollmentPolicy;
use App\Policies\User\UserPolicy;
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
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(Enrollment::class, EnrollmentPolicy::class);
        Gate::policy(ExamAttempt::class, ExamAttemptPolicy::class);
    }
}
