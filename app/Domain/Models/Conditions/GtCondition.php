<?php

declare(strict_types=1);

namespace App\Domain\Models\Conditions;

use App\Domain\Interfaces\CanProvideValueInterface;
use Webmozart\Assert\Assert;

final class GtCondition extends AbstractCondition
{
    public function __construct(private readonly CanProvideValueInterface $condition, private readonly mixed $value) {}

    public function isSatisfied(): bool
    {
        return $this->isValid($this->value, $this->condition->getValue());
    }

    public function isValid(mixed $value, mixed $limit): bool
    {
        return $this->assertIsValid(
            fn(mixed $value, mixed $limit) => Assert::greaterThan($value, $limit),
            $value,
            $limit
        );
    }
}
