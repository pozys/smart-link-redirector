<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

interface HasConditionsInterface
{
    /**
     * @return ConditionInterface[]
     */
    public function conditions(): array;
}
