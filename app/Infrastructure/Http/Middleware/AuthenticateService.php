<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateService
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(config('services.auth_service.url') . '/verify-token');

        if ($response->status() !== 200) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $request->merge(['user' => $response->json('user')]);

        return $next($request);
    }
}
