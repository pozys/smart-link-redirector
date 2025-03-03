<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

interface CanProvideExaminedValue
{
    public function getCurrentValue(): ValueWrapperInterface;
}
