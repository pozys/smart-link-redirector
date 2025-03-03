<?php

declare(strict_types=1);

namespace App\Domain\Models\Conditions;

use App\Domain\Interfaces\ConditionInterface;
use App\Domain\Models\ConditionValue;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasOne, MorphTo};
use Illuminate\Database\Eloquent\SoftDeletes;

class Condition extends Model implements ConditionInterface
{
    use HasFactory, SoftDeletes;

    public function isValid(mixed $value, mixed $expect): bool
    {
        return $this->conditionType->isValid($value, $expect);
    }

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    public function conditionValue(): HasOne
    {
        return $this->hasOne(ConditionValue::class);
    }

    protected function conditionType(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value, array $attributes): ConditionInterface => app($value ?? $attributes['condition_type']),
            set: fn(mixed $value) => get_class($value),
        );
    }
}
