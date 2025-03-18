<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\Interfaces\ConditionInterface;
use Closure;
use Illuminate\Database\Eloquent\Model;

final class ConditionInterfaceBridge implements ConditionInterface
{
    private Closure $concrete;

    public function __construct(Model $object, array $args)
    {
        $this->concrete = app("$object->rule_type.isSatisfied", $args);
    }

    public function isSatisfied(): bool
    {
        return call_user_func($this->concrete);
    }
}
