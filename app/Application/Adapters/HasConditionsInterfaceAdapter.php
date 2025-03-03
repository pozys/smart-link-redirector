<?php

declare(strict_types=1);

namespace App\Application\Adapters;

use App\Domain\Interfaces\ConditionValueInterface;
use App\Domain\Interfaces\HasConditionsInterface;
use App\Domain\Models\Conditions\Condition;
use App\Domain\Models\Rules\Rule;
use Illuminate\Support\Collection;

class HasConditionsInterfaceAdapter implements HasConditionsInterface
{
    public function __construct(private readonly Rule $adaptee) {}

    /** @return Collection<ConditionValueInterface> */
    public function getConditions(): Collection
    {
        return $this->adaptee->conditions
            ->map(fn(Condition $condition): ConditionValueInterface => $condition->conditionValue);
    }
}
