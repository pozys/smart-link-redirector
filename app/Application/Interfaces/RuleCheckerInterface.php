<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\DTO\RuleDto;

interface RuleCheckerInterface
{
    public function satisfies(RuleDto $rule): bool;
}
