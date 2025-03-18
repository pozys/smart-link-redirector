<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Interfaces\ComparatorInterface;
use App\Domain\Interfaces\ConditionInterface;

class StrictComparator implements ComparatorInterface
{
    public function isApplicable(ConditionInterface ...$rules): bool
    {
        return collect($rules)->every(fn(ConditionInterface $rule): bool => $rule->isSatisfied());
    }
}
