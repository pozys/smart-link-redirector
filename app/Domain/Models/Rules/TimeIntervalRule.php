<?php

declare(strict_types=1);

namespace App\Domain\Models\Rules;

use App\Domain\Interfaces\{ConditionInterface, HasConditionsInterface};
use Carbon\Carbon;

final class TimeIntervalRule
{
    public function __construct(private readonly HasConditionsInterface $rule) {}

    public static function provideValue(): Carbon
    {
        return now();
    }

    public function isSatisfied(): bool
    {
        return collect($this->rule->conditions())
            ->every(fn(ConditionInterface $condition): bool => $condition->isSatisfied());
    }
}
