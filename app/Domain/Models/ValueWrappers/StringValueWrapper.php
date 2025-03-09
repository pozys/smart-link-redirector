<?php

declare(strict_types=1);

namespace App\Domain\Models\ValueWrappers;

use App\Domain\Interfaces\ValueWrapperInterface;

final class StringValueWrapper implements ValueWrapperInterface
{
    public function __construct(private readonly string $value) {}

    public function getValue(): string
    {
        return $this->cast($this->value);
    }

    public function cast(string $value): string
    {
        return strtolower((string) $value);
    }
}
