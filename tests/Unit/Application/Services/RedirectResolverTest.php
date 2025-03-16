<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Services;

use App\Application\Interfaces\{ComparatorInterface, RedirectLinkRepositoryInterface, RuleCheckerInterface};
use App\Application\Services\RedirectResolver;
use App\Domain\Interfaces\{LinkInterface, RedirectLinkInterface};
use App\Domain\Models\Rules\Rule;
use PHPUnit\Framework\MockObject\Stub;
use Tests\TestCase;

final class RedirectResolverTest extends TestCase
{
    public function testResolveFirstApplicableRedirect(): void
    {
        $redirectLinkProvider = $this->createStub(RedirectLinkRepositoryInterface::class);

        $firstApplicableRedirect = $this->stubRedirect();
        $secondRedirect = $this->stubRedirect();

        $comparator = $this->stubComparator(true, false);

        $redirectLinkProvider->method('findRedirects')->willReturn([$firstApplicableRedirect, $secondRedirect]);

        $link = $this->createStub(LinkInterface::class);
        $redirectResolver = app()->make(
            RedirectResolver::class,
            ['redirectLinkRepository' => $redirectLinkProvider, 'comparator' => $comparator]
        );

        $this->assertSame($firstApplicableRedirect, $redirectResolver->resolve($link));
    }

    public function testResolveAllRedirectsNotApplicable(): void
    {
        $redirectLinkProvider = $this->createStub(RedirectLinkRepositoryInterface::class);

        $redirectLink = $this->createStub(RedirectLinkInterface::class);
        $redirectLink->method('getRules')->willReturn([]);

        $comparator = $this->createStub(ComparatorInterface::class);

        $redirectLinkProvider->method('findRedirects')->willReturn([$redirectLink]);

        $link = $this->createStub(LinkInterface::class);
        $redirectResolver = app()->make(
            RedirectResolver::class,
            ['redirectLinkRepository' => $redirectLinkProvider, 'comparator' => $comparator]
        );

        $this->assertNull($redirectResolver->resolve($link));
    }

    public function testResolveNoRedirectsFound(): void
    {
        $redirectLinkProvider = $this->createStub(RedirectLinkRepositoryInterface::class);
        $redirectLinkProvider->method('findRedirects')->willReturn([]);

        $link = $this->createStub(LinkInterface::class);
        $redirectResolver = new RedirectResolver(
            $redirectLinkProvider,
            $this->createStub(ComparatorInterface::class)
        );

        $this->assertNull($redirectResolver->resolve($link));
    }

    private function stubRedirect(): Stub
    {
        $redirectLink = $this->createStub(RedirectLinkInterface::class);
        $redirectLink->method('getLink')->willReturn($this->faker->url());

        return $redirectLink;
    }

    private function stubComparator(bool ...$results): ComparatorInterface
    {
        $ruleChecker = $this->createStub(RuleCheckerInterface::class);
        $ruleChecker->method('satisfies')->willReturn(...$results);

        return app(ComparatorInterface::class, compact('ruleChecker'));
    }
}
