<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Services;

use App\Application\Interfaces\{ComparatorInterface, RedirectLinkRepositoryInterface};
use App\Application\Services\RedirectResolver;
use App\Domain\Interfaces\{ConditionInterface, LinkInterface, RedirectLinkInterface};
use PHPUnit\Framework\MockObject\Stub;
use Tests\TestCase;

final class RedirectResolverTest extends TestCase
{
    public function testResolvePositive(): void
    {
        $redirectLinkProvider = $this->createStub(RedirectLinkRepositoryInterface::class);

        $rightRedirect = $this->stubRedirect(true, true);
        $wrongRedirect = $this->stubRedirect(true, false);

        $redirectLinkProvider->method('findRedirects')->willReturn([$wrongRedirect, $rightRedirect]);

        $link = $this->createStub(LinkInterface::class);
        $redirectResolver = app()->make(
            RedirectResolver::class,
            ['redirectLinkRepository' => $redirectLinkProvider]
        );

        $this->assertSame($rightRedirect, $redirectResolver->resolve($link));
    }

    public function testResolveRulesNotMatch(): void
    {
        $redirectLinkProvider = $this->createStub(RedirectLinkRepositoryInterface::class);

        $redirectLinkProvider->method('findRedirects')->willReturn([
            $this->stubRedirect(false, false),
            $this->stubRedirect(false, false)
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

    private function stubRedirect(bool ...$results): Stub
    {
        $redirectLink = $this->createStub(RedirectLinkInterface::class);
        $redirectLink->method('getLink')->willReturn(fake()->url());
        $redirectLink->method('getRules')->willReturn(
            collect($results)->map(fn(bool $result): ConditionInterface => $this->stubCondition($result))->all()
        );

        return $redirectLink;
    }

    private function stubCondition(bool $isSatisfied = true): ConditionInterface
    {
        $condition = $this->createStub(ConditionInterface::class);
        $condition->method('isSatisfied')->willReturn($isSatisfied);

        return $condition;
    }
}
