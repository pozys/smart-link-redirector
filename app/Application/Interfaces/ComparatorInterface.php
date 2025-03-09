<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\Models\Rules\Rule;

interface ComparatorInterface
{
    public function isApplicable(Rule ...$rules): bool;
}
