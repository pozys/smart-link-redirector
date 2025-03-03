<?php

declare(strict_types=1);

namespace App\Application\Adapters;

use App\Domain\Interfaces\{CanProvideExaminedValue, RuleInterface, ValueWrapperInterface};
use App\Domain\Models\Rules\Rule;

class CanProvideExaminedValueAdapter implements CanProvideExaminedValue
{
    public function __construct(private readonly Rule $rule) {}

    public function getCurrentValue(): ValueWrapperInterface
    {
        return new class($this->rule->ruleType) implements ValueWrapperInterface {
            private readonly string $ruleName;

            public function __construct(RuleInterface $rule)
            {
                $this->ruleName = get_class($rule);
            }

            public function getValue(): string
            {
                $value = app("$this->ruleName.provideValue")();

                return $this->cast($value);
            }

            public function cast(mixed $value): string
            {
                $caster = app("$this->ruleName.castValue");

                return $caster($value);
            }
        };
    }
}
