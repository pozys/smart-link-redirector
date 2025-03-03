<?php

declare(strict_types=1);

namespace App\Domain\Traits;

use App\Domain\Models\Conditions\Condition;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasConditions
{
    public function conditions(): MorphMany
    {
        return $this->morphMany(Condition::class, 'owner');
    }
}
