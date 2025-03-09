<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Interfaces\{ComparatorInterface, RedirectLinkRepositoryInterface, RedirectResolverInterface};
use App\Domain\Interfaces\{LinkInterface, RedirectLinkInterface};

class RedirectResolver implements RedirectResolverInterface
{
    public function __construct(
        private readonly RedirectLinkRepositoryInterface $redirectLinkRepository,
        private readonly ComparatorInterface $comparator,
    ) {}

    public function resolve(LinkInterface $link): ?RedirectLinkInterface
    {
        $redirects = $this->redirectLinkRepository->findRedirects($link);

        return collect($redirects)
            ->first(fn(RedirectLinkInterface $candidate): bool => $this->comparator->isApplicable(...$candidate->getRules()));
    }
}
