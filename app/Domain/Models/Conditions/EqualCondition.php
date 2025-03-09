<?php

declare(strict_types=1);

namespace App\Domain\Models\Conditions;

use Webmozart\Assert\Assert;

final class EqualCondition extends AbstractCondition
{
    public function isValid(mixed $value, mixed $expect): bool
    {
        return $this->assertIsValid(
            fn(mixed $value, mixed $expect) => Assert::eq($value, $expect),
            $value,
            $expect
        );
    }
}
