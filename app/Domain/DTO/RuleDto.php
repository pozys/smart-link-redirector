<?php

declare(strict_types=1);

namespace App\Domain\DTO;

use App\Domain\Interfaces\{CanProvideExaminedValue, RuleInterface};

final class RuleDto
{
    public function __construct(
        public readonly RuleInterface $rule,
        public readonly CanProvideExaminedValue $valueProvider
    ) {}
}
