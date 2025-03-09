<?php

declare(strict_types=1);

namespace App\Domain\Models\Conditions;

use Webmozart\Assert\Assert;

final class LteCondition extends AbstractCondition
{
    public function isValid(mixed $value, mixed $limit): bool
    {
        return $this->assertIsValid(
            fn(mixed $value, mixed $limit) => Assert::lessThanEq($value, $limit),
            $value,
            $limit
        );
    }
}
