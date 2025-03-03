<?php

namespace App\Domain\Models;

use App\Domain\Interfaces\{ConditionValueInterface, ValueWrapperInterface};
use App\Domain\Models\Conditions\Condition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConditionValue extends Model implements ConditionValueInterface
{
    use HasFactory, SoftDeletes;

    public function isSatisfiedBy(ValueWrapperInterface $valueWrapper): bool
    {
        return $this->condition->isValid($valueWrapper->getValue(), $valueWrapper->cast($this->value));
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }
}
