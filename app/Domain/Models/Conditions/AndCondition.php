<?php

declare(strict_types=1);

namespace App\Domain\Models\Conditions;

use App\Domain\Interfaces\{ConditionInterface, HasConditionsInterface};

final class AndCondition
{
    public function __construct(
        private readonly HasConditionsInterface $condition,
        private readonly mixed $examinedValue
    ) {}

    public function isSatisfied(): bool
    {
        return collect($this->condition->conditions())
            ->every(fn(ConditionInterface $condition): bool => $condition->isSatisfied());
    }
}
