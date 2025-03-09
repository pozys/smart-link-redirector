<?php

declare(strict_types=1);

namespace App\Domain\Models\Conditions;

use App\Domain\Interfaces\{RuleInterface, ValueWrapperInterface};

final class AndCondition
{
    public function isValid(ValueWrapperInterface $value, RuleInterface ...$conditions): bool
    {
        return collect($conditions)->every(fn(RuleInterface $condition): bool => $condition->isSatisfiedBy($value));
    }
}
