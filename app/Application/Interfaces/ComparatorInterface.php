<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\DTO\RuleDto;

interface ComparatorInterface
{
    public function isApplicable(RuleDto ...$rules): bool;
}
