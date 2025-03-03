<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Adapters\{CanProvideExaminedValueAdapter, HasConditionsInterfaceAdapter};
use App\Application\Interfaces\{ComparatorInterface, RuleCheckerInterface};
use App\Domain\Models\Rules\Rule;

class RuleChecker implements RuleCheckerInterface
{
    public function __construct(private readonly ComparatorInterface $comparator) {}

    public function isApplicable(Rule $rule): bool
    {
        return $this->comparator->matches(
            app()->make(HasConditionsInterfaceAdapter::class, ['adaptee' => $rule]),
            app()->make(CanProvideExaminedValueAdapter::class, ['rule' => $rule])->getCurrentValue(),
        );
    }
}
