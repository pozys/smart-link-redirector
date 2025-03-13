<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructure\Services\Auth\AuthServiceGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

final class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Auth::extend('auth_service', function (Application $app) {
            return new AuthServiceGuard(
                $app->make(AuthServiceUserProvider::class, ['app' => $app]),
                $app['request']
            );
        });
    }
}
