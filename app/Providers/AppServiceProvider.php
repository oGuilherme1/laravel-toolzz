<?php

namespace App\Providers;

use App\Gateways\Auth\AuthGateway;
use App\Gateways\User\UserGateway;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Services\User\CreateUserService;
use App\Services\Auth\GenerateTokenService;
use App\Services\Auth\LogoutService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CreateUserService::class, function ($app) {
            return CreateUserService::create($app->make(UserRepository::class));
        });

        $this->app->singleton(UserGateway::class, function ($app) {
            return new UserRepository;
        });

        $this->app->singleton(GenerateTokenService::class, function ($app) {
            return GenerateTokenService::create($app->make(AuthRepository::class), $app->make(UserRepository::class));
        });

        $this->app->singleton(AuthGateway::class, function ($app) {
            return new AuthRepository;
        });

        $this->app->singleton(LogoutService::class, function ($app) {
            return LogoutService::create($app->make(AuthRepository::class));
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
