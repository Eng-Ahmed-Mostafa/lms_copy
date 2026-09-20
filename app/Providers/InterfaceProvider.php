<?php

namespace App\Providers;

use App\Interface\Api\Auth\AuthInterface;
use App\Interface\Api\User\UserInterface;
use App\Repository\Api\Auth\AuthRepository;
use App\Repository\Api\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class InterfaceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthInterface::class,
            AuthRepository::class
        );

        $this->app->bind(
            UserInterface::class,
            UserRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
