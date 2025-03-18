<?php

declare(strict_types=1);

namespace App\Application\Adapters;

use App\Domain\Interfaces\CanProvideValueInterface;
use Illuminate\Database\Eloquent\Model;

final class CanProvideValueAdapter implements CanProvideValueInterface
{
    public function __construct(private readonly Model $adaptee) {}

    public function getValue(): mixed
    {
        return $this->adaptee->conditionValue;
    }
}
