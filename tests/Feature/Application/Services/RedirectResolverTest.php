<?php

declare(strict_types=1);

namespace Tests\Feature\Application\Services;

use App\Application\Interfaces\{ComparatorInterface, RedirectLinkRepositoryInterface, RuleCheckerInterface};
use App\Application\Services\RedirectResolver;
use App\Domain\Interfaces\{LinkInterface, RedirectLinkInterface};
use App\Domain\Models\Rules\Rule;
use PHPUnit\Framework\MockObject\Stub;
use Tests\Factories\RuleDtoFactory;
use Tests\TestCase;

final class RedirectResolverTest extends TestCase
{
    public function testResolvePositive(): void
    {
        $redirectLinkProvider = $this->createStub(RedirectLinkRepositoryInterface::class);

        $rightRedirect = $this->stubRedirect();
        $wrongRedirect = $this->stubRedirect();

        $comparator = $this->stubComparator(true, false, true, true);

        $redirectLinkProvider->method('findRedirects')->willReturn([$wrongRedirect, $rightRedirect]);

        $link = $this->createStub(LinkInterface::class);
        $redirectResolver = app()->make(
            RedirectResolver::class,
            ['redirectLinkRepository' => $redirectLinkProvider, 'comparator' => $comparator]
        );

        $this->assertSame($rightRedirect, $redirectResolver->resolve($link));
    }

    public function testResolveRulesNotMatch(): void
    {
        $redirectLinkProvider = $this->createStub(RedirectLinkRepositoryInterface::class);

        $redirectLinkProvider->method('findRedirects')->willReturn([
            $this->stubRedirect(),
            $this->stubRedirect()
        ]);

        $link = $this->createStub(LinkInterface::class);
        $redirectResolver = app()->make(
            RedirectResolver::class,
            [
                'redirectLinkRepository' => $redirectLinkProvider,
                'comparator' => $this->createStub(ComparatorInterface::class)
            ]
        );

        $this->assertNull($redirectResolver->resolve($link));
    }

    private function stubRedirect(): Stub
    {
        $redirectLink = $this->createStub(RedirectLinkInterface::class);
        $redirectLink->method('getLink')->willReturn(fake()->url());
        $redirectLink->method('getRules')->willReturn([
            RuleDtoFactory::make(),
            RuleDtoFactory::make(),
        ]);

        return $redirectLink;
    }

    private function stubComparator(bool ...$results): ComparatorInterface
    {
        $ruleChecker = $this->createStub(RuleCheckerInterface::class);
        $ruleChecker->method('satisfies')->willReturn(...$results);

        return app(ComparatorInterface::class, compact('ruleChecker'));
    }
}
