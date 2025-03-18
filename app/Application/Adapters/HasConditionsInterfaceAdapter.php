<?php

declare(strict_types=1);

namespace App\Application\Adapters;

use App\Domain\Interfaces\{ConditionInterface, HasConditionsInterface};
use Illuminate\Database\Eloquent\Model;

final class HasConditionsInterfaceAdapter implements HasConditionsInterface
{
    public function __construct(private readonly Model $adaptee, private readonly mixed $value) {}

    public function conditions(): array
    {
        return $this->adaptee->conditions
            ->map(
                fn(Model $condition): ConditionInterface => new ConditionInterfaceAdapter($condition, $this->value)
            )
            ->all();
    }
}
