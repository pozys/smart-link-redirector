<?php

declare(strict_types=1);

namespace App\Domain\Models\ValueWrappers;

use App\Domain\Interfaces\ValueWrapperInterface;

final class IntegerValueWrapper implements ValueWrapperInterface
{
    public function __construct(private readonly string $value) {}

    public function getValue(): int
    {
        return $this->cast($this->value);
    }

    public function cast(string $value): int
    {
        return (int) $value;
    }
}
