<?php

declare(strict_types=1);

namespace App\Application\Adapters;

use App\Domain\Interfaces\{RuleInterface, ValueWrapperInterface};
use App\Domain\Models\Rules\Rule;

final class RuleInterfaceAdapter implements RuleInterface
{
    public function __construct(private readonly Rule $adaptee) {}

    public function isSatisfiedBy(ValueWrapperInterface $value): bool
    {
        return app('RuleInterface.isSatisfiedBy', [$this->adaptee])($value);
    }

    public function ruleType(): string
    {
        return app('RuleInterface.ruleType', [$this->adaptee]);
    }

    public function value(): string
    {
        return app('RuleInterface.value', [$this->adaptee]);
    }

    public function conditions(): array
    {
        return app('RuleInterface.conditions', [$this->adaptee]);
    }
}
