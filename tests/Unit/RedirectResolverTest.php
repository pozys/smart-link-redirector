<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Application\Interfaces\{RedirectLinkRepositoryInterface, RuleCheckerInterface};
use App\Application\Services\RedirectResolver;
use App\Domain\Interfaces\{LinkInterface, RedirectLinkInterface};
use App\Domain\Models\Rules\Rule;
use PHPUnit\Framework\MockObject\Stub;
use Tests\TestCase;

final class RedirectResolverTest extends TestCase
{
    public function testResolvePositive(): void
    {
        $redirectLinkProvider = $this->createMock(RedirectLinkRepositoryInterface::class);

        $rightRedirect = $this->stubRedirect();
        $wrongRedirect = $this->stubRedirect();

        $ruleChecker = $this->stubRuleChecker(true, false, true, true);

        $redirectLinkProvider->method('findRedirects')->willReturn([$wrongRedirect, $rightRedirect]);

        $link = $this->createMock(LinkInterface::class);
        $redirectResolver = app()->make(
            RedirectResolver::class,
            ['redirectLinkRepository' => $redirectLinkProvider, 'ruleChecker' => $ruleChecker]
        );

        $this->assertSame($rightRedirect, $redirectResolver->resolve($link));
    }

    public function testResolveRulesNotFound(): void
    {
        $redirectLinkProvider = $this->createMock(RedirectLinkRepositoryInterface::class);

        $redirectLinkProvider->method('findRedirects')->willReturn([]);

        $link = $this->createMock(LinkInterface::class);
        $redirectResolver = app()->make(
            RedirectResolver::class,
            ['redirectLinkRepository' => $redirectLinkProvider, 'ruleChecker' => $this->createStub(RuleCheckerInterface::class)]
        );

        $this->assertNull($redirectResolver->resolve($link));
    }

    public function testResolveRulesNotMatch(): void
    {
        $redirectLinkProvider = $this->createMock(RedirectLinkRepositoryInterface::class);

        $wrongRedirect1 = $this->stubRedirect();
        $wrongRedirect2 = $this->stubRedirect();

        $redirectLinkProvider->method('findRedirects')->willReturn([$wrongRedirect1, $wrongRedirect2]);

        $link = $this->createMock(LinkInterface::class);
        $redirectResolver = app()->make(
            RedirectResolver::class,
            ['redirectLinkRepository' => $redirectLinkProvider, 'ruleChecker' => $this->createStub(RuleCheckerInterface::class)]
        );

        $this->assertNull($redirectResolver->resolve($link));
    }

    private function stubRedirect(): Stub
    {
        $rule1 = $this->createStub(Rule::class);
        $rule2 = $this->createStub(Rule::class);
        $redirectLink = $this->createStub(RedirectLinkInterface::class);
        $redirectLink->method('getLink')->willReturn('https://example.com');
        $redirectLink->method('getRules')->willReturn(collect([$rule1, $rule2]));

        return $redirectLink;
    }

    private function stubRuleChecker(bool ...$results): Stub
    {
        $ruleChecker = $this->createStub(RuleCheckerInterface::class);
        $ruleChecker->method('isApplicable')->willReturn(...$results);

        return $ruleChecker;
    }
}
