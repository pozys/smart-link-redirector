<?php

declare(strict_types=1);

namespace Tests\Feature\App\Infrastructure\Services\Auth;

use App\Application\Interfaces\{RedirectLinkRepositoryInterface, RedirectResolverInterface};
use App\Domain\Interfaces\RedirectLinkInterface;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

final class AuthServiceGuardTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $redirectLinkRepository = $this->createStub(RedirectLinkRepositoryInterface::class);
        $redirectLinkRepository->method('findRedirects')->willReturn([]);
    }

    public function testSuccessfulAuthentication(): void
    {
        Http::fake([
            config('services.auth_service.url') . '/verify-token' => Http::response([
                'user' => [
                    'id' => 1,
                    'name' => $this->faker->name(),
                    'email' => $this->faker->email(),
                ],
            ], 200),
        ]);

        $resolver = $this->createStub(RedirectResolverInterface::class);
        $redirectLink = $this->createStub(RedirectLinkInterface::class);
        $redirectLink->method('getLink')->willReturn($this->faker->url());
        $resolver->method('resolve')->willReturn($redirectLink);

        $this->instance(RedirectResolverInterface::class, $resolver);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer valid-token',
        ])->get('/redirect/url');

        $response->assertRedirect();
    }

    public function testInvalidToken(): void
    {
        Http::fake([
            config('services.auth_service.url') . '/verify-token' => Http::response([
                'error' => 'Invalid token',
            ], 401),
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalid-token',
        ])->get('/redirect/url');

        $response->assertUnauthorized();
    }

    public function testMissingToken(): void
    {
        $response = $this->get('/redirect/url');

        $response->assertUnauthorized();
    }
}
