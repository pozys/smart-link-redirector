<?php

declare(strict_types=1);

namespace Tests\Feature\App\Infrastructure\Http\Routes\Web;

use App\Application\Interfaces\RedirectResolverInterface;
use App\Domain\Interfaces\{LinkInterface, RedirectLinkInterface};
use App\Domain\Models\Link;
use App\Infrastructure\Http\Middleware\AuthenticateService;
use Mockery;
use Tests\Factories\UserFactory;
use Tests\TestCase;

final class RedirectTest extends TestCase
{
    private const ROUTE = 'redirect';

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(AuthenticateService::class);
    }

    public function testRedirectSuccess(): void
    {
        $linkUuid = Link::factory()->create()->id;

        $redirectLink = $this->createStub(RedirectLinkInterface::class);
        $redirectLink->method('getLink')->willReturn($this->faker->url());

        $redirectResolver = $this->createMock(RedirectResolverInterface::class);
        $redirectResolver = Mockery::mock($redirectResolver);
        $redirectResolver->shouldReceive('resolve')
            ->once()
            ->with(Mockery::on(static fn(LinkInterface $link): bool => $link->id === $linkUuid))
            ->andReturn($redirectLink);

        $this->app->instance(RedirectResolverInterface::class, $redirectResolver);

        $this->actingAs(UserFactory::make())->get(route(self::ROUTE, ['link' => $linkUuid]))->assertRedirect();
    }
}
