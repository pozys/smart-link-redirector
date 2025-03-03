<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

interface RuleProviderInterface
{
    public function getRule(): CanProvideExaminedValue;
}
