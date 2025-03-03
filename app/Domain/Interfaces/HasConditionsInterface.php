<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use Illuminate\Support\Collection;

interface HasConditionsInterface
{
    /** @return Collection<ConditionValueInterface> */
    public function getConditions(): Collection;
}
