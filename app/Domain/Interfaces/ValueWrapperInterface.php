<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

interface ValueWrapperInterface
{
    public function getValue(): mixed;

    public function cast(mixed $value): mixed;
}
