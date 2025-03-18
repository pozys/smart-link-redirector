<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\Interfaces\ConditionInterface;

interface ComparatorInterface
{
    public function isApplicable(ConditionInterface ...$rules): bool;
}
