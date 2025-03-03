<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Interfaces\ComparatorInterface;
use App\Domain\Interfaces\{ConditionValueInterface, HasConditionsInterface, ValueWrapperInterface};

class StrictComparator implements ComparatorInterface
{
    public function matches(HasConditionsInterface $candidate, ValueWrapperInterface $valueWrapper): bool
    {
        return $candidate->getConditions()->every(
            fn(ConditionValueInterface $condition): bool => $condition->isSatisfiedBy($valueWrapper)
        );
    }
}
