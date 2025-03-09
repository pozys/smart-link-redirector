<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Adapters\{CanProvideExaminedValueAdapter, RuleInterfaceAdapter};
use App\Application\Interfaces\RuleCheckerInterface;
use App\Domain\Models\Rules\Rule;

class RuleChecker implements RuleCheckerInterface
{
    public function satisfies(Rule $rule): bool
    {
        return app(RuleInterfaceAdapter::class, ['adaptee' => $rule])
            ->isSatisfiedBy(app(CanProvideExaminedValueAdapter::class, ['adaptee' => $rule])->getCurrentValue());
    }
}
