<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

interface ConditionInterface
{
    public function isSatisfied(): bool;
}
