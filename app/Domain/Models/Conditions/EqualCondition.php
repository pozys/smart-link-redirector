<?php

declare(strict_types=1);

namespace App\Domain\Models\Conditions;

use App\Domain\Traits\AssertionValidator;
use Webmozart\Assert\Assert;

final class EqualCondition
{
    use AssertionValidator;

    public function isValid(mixed $value, mixed $expected): bool
    {
        return $this->assertIsValid(
            fn(mixed $value, mixed $expected) => Assert::eq($value, $expected),
            $value,
            $expected
        );
    }
}
