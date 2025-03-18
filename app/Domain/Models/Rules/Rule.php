<?php

declare(strict_types=1);

namespace App\Domain\Models\Rules;

use App\Domain\Models\{ConditionValue, RedirectLink};
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasOne, MorphMany, MorphTo};
use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends Model
{
    use HasFactory, SoftDeletes;

    public function redirectLink(): MorphTo
    {
        return $this->morphTo('owned')->where('owned_type', RedirectLink::class);
    }

    public function value(): HasOne
    {
        return $this->hasOne(ConditionValue::class, 'rule_id');
    }

    protected function conditionValue(): Attribute
    {
        return Attribute::make(
            get: fn(): mixed => $this->value->value,
        );
    }

    public function conditions(): MorphMany
    {
        return $this->morphMany(Rule::class, 'owned');
    }
}
