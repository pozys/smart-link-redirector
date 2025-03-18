<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\{Authenticatable, Guard, UserProvider};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

final class AuthServiceGuard implements Guard
{
    use GuardHelpers;

    public function __construct(UserProvider $provider, private readonly Request $request)
    {
        $this->provider = $provider;
    }

    public function user(): ?Authenticatable
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $token = $this->request->bearerToken();

        if (!$token) {
            return null;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(config('services.auth_service.url') . '/verify-token');

        if ($response->status() !== 200) {
            return null;
        }

        $userData = $response->json('user');

        $this->user = $this->provider->retrieveByCredentials($userData);

        return $this->user;
    }

    public function validate(array $credentials = []): bool
    {
        return false;
    }
}
