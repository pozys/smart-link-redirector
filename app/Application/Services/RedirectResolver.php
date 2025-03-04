<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Interfaces\{RedirectLinkRepositoryInterface, RedirectResolverInterface, RuleCheckerInterface};
use App\Domain\Interfaces\{LinkInterface, RedirectLinkInterface};
use App\Domain\Models\Rules\Rule;

class RedirectResolver implements RedirectResolverInterface
{
    public function __construct(
        private readonly RedirectLinkRepositoryInterface $redirectLinkRepository,
        private readonly RuleCheckerInterface $ruleChecker,
    ) {}

    public function resolve(LinkInterface $link): ?RedirectLinkInterface
    {
        $redirects = $this->redirectLinkRepository->findRedirects($link);

        return collect($redirects)
            ->first(
                fn(RedirectLinkInterface $candidate): bool => collect($candidate->getRules())
                    ->every(fn(Rule $rule): bool => $this->ruleChecker->isApplicable($rule))
            );
    }
}
