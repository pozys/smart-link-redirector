<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Interfaces\{RuleCheckerInterface, ComparatorInterface};
use App\Domain\Models\Rules\Rule;

class StrictComparator implements ComparatorInterface
{
    public function __construct(private readonly RuleCheckerInterface $ruleChecker) {}

    public function isApplicable(Rule ...$rules): bool
    {
        return collect($rules)->every(fn(Rule $rule): bool => $this->ruleChecker->satisfies($rule));
    }
}
