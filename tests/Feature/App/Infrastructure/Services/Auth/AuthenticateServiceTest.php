<?php

declare(strict_types=1);

namespace Tests\Feature\App\Infrastructure\Services\Auth;

use Illuminate\Http\Client\{Factory, Request};
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

final class AuthenticateServiceTest extends TestCase
{
    public function testRequestIsSent(): void
    {
        $this->fakeAuthServiceResponse([
            'user' => [
                'id' => 1,
                'name' => $this->faker->name(),
                'email' => $this->faker->email(),
            ]
        ], 200);

        $token = 'valid-token';

        $this->sendWithHeaders(['Authorization' => "Bearer $token"]);

        Http::assertSent(
            fn(Request $request) => $request->url() === config('services.auth_service.url') . '/verify-token'
                && $request->header('Authorization')[0] === "Bearer $token"
        );
    }

    public function testSuccessfulAuthentication(): void
    {
        $this->fakeAuthServiceResponse([
            'user' => [
                'id' => 1,
                'name' => $this->faker->name(),
                'email' => $this->faker->email(),
            ]
        ], 200);

        $this->sendWithHeaders(['Authorization' => 'Bearer valid-token']);

        $this->assertAuthenticated();
    }

    public function testInvalidToken(): void
    {
        $this->fakeAuthServiceResponse(['error' => 'Invalid token'], 401);

        $this->sendWithHeaders(['Authorization' => 'Bearer invalid-token']);

        $this->assertGuest();
    }

    public function testMissingToken(): void
    {
        $this->sendWithHeaders();

        $this->assertGuest();
    }

    private function fakeAuthServiceResponse(array $response, int $status): Factory
    {
        return Http::fake([
            config('services.auth_service.url') . '/verify-token' => Http::response($response, $status)
        ]);
    }

    private function sendWithHeaders(array $headers = []): TestResponse
    {
        return $this->withHeaders($headers)->get('/redirect/url');
    }
}
