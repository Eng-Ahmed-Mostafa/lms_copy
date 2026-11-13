<?php

namespace App\Providers;

use App\Events\Auth\UserRegistered;
use App\Listeners\Auth\SendVerificationEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(
            UserRegistered::class,
            SendVerificationEmail::class
        );
    }
}
