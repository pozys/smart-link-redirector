<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Interfaces\RuleCheckerInterface;
use App\Domain\DTO\RuleDto;

class RuleChecker implements RuleCheckerInterface
{
    public function satisfies(RuleDto $ruleDto): bool
    {
        return $ruleDto->rule->isSatisfiedBy($ruleDto->valueProvider->getCurrentValue());
    }
}
