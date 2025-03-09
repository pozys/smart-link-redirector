<?php

declare(strict_types=1);

namespace App\Domain\Models\Conditions;

use Closure;

abstract class AbstractCondition
{
    abstract public function isValid(mixed $value, mixed $expected): bool;

    public function assertIsValid(Closure $assertion, mixed ...$values): bool
    {
        try {
            call_user_func($assertion, ...$values);
        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }
}
