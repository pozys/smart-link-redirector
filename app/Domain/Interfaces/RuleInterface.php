<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

interface RuleInterface
{
    public function isSatisfiedBy(ValueWrapperInterface $value): bool;

    public function ruleType(): string;

    public function conditions(): array;

    public function value(): string;
}
