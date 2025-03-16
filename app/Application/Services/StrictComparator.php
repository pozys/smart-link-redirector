<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Interfaces\{RuleCheckerInterface, ComparatorInterface};
use App\Domain\DTO\RuleDto;

class StrictComparator implements ComparatorInterface
{
    public function __construct(private readonly RuleCheckerInterface $ruleChecker) {}

    public function isApplicable(RuleDto ...$rules): bool
    {
        return collect($rules)->every(fn(RuleDto $ruleDto): bool => $this->ruleChecker->satisfies($ruleDto));
    }
}
