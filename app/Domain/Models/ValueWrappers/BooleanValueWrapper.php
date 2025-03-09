<?php

declare(strict_types=1);

namespace App\Domain\Models\ValueWrappers;

use App\Domain\Interfaces\ValueWrapperInterface;

final class BooleanValueWrapper implements ValueWrapperInterface
{
    public function __construct(private readonly string $value) {}

    public function getValue(): bool
    {
        return $this->cast($this->value);
    }

    public function cast(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
