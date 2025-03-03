<?php

declare(strict_types=1);

namespace App\Domain\Models\Conditions;

use App\Domain\Interfaces\ConditionInterface;
use App\Domain\Traits\AssertionValidator;
use Webmozart\Assert\Assert;

final class EqualCondition implements ConditionInterface
{
    use AssertionValidator;

    public function isValid(mixed $value, mixed $expected): bool
    {
        return $this->assertIsValid(
            fn(mixed $value, mixed $expected) => Assert::same($value, $expected),
            $value,
            $expected
        );
    }
}
