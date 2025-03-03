<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\Models\Rules\Rule;

interface RuleCheckerInterface
{
    public function isApplicable(Rule $rule): bool;
}
