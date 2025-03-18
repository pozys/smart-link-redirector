<?php

declare(strict_types=1);

namespace App\Application\Adapters;

use App\Domain\Interfaces\ConditionInterface;
use Illuminate\Database\Eloquent\Model;

final class ConditionInterfaceAdapter implements ConditionInterface
{
    public function __construct(private readonly Model $adaptee, private readonly mixed $value) {}

    public function isSatisfied(): bool
    {
        return app('ConditionInterface.isSatisfied', [$this->adaptee, $this->value])();
    }
}
