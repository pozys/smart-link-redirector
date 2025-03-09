<?php

declare(strict_types=1);

namespace App\Domain\Models\ValueWrappers;

use App\Domain\Interfaces\ValueWrapperInterface;

final class FloatValueWrapper implements ValueWrapperInterface
{
    public function __construct(private readonly string $value) {}

    public function getValue(): float
    {
        return $this->cast($this->value);
    }

    public function cast(string $value): float
    {
        return (float) $value;
    }
}
