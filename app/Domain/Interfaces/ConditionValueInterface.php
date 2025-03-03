<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

interface ConditionValueInterface
{
    public function isSatisfiedBy(ValueWrapperInterface $value): bool;
}
