<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domain\Models\User;
use Illuminate\Contracts\Auth\{Authenticatable, UserProvider};
use Illuminate\Support\ServiceProvider;

class AuthServiceUserProvider extends ServiceProvider implements UserProvider
{
    public function retrieveById($identifier): ?Authenticatable
    {
        return User::find($identifier);
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
        // Этот метод не используется в нашем Guard
    }

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        return new User([
            'id' => $credentials['id'],
            'name' => $credentials['name'],
            'email' => $credentials['email'],
        ]);
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return false;
    }

    public function rehashPasswordIfRequired(
        Authenticatable $user,
        #[\SensitiveParameter] array $credentials,
        bool $force = false
    ): void {
        // Этот метод не используется в нашем Guard
    }
}
