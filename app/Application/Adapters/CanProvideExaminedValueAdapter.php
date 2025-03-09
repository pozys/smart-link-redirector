<?php

declare(strict_types=1);

namespace App\Application\Adapters;

use App\Domain\Interfaces\{CanProvideExaminedValue, ValueWrapperInterface};
use App\Domain\Models\Rules\Rule;

class CanProvideExaminedValueAdapter implements CanProvideExaminedValue
{
    public function __construct(private readonly Rule $adaptee) {}

    public function getCurrentValue(): ValueWrapperInterface
    {
        return app('CanProvideExaminedValue.getCurrentValue', [$this->adaptee]);
    }
}
