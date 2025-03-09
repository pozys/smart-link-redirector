<?php

declare(strict_types=1);

namespace App\Domain\Models\Rules;

use App\Domain\Models\{ConditionValue, RedirectLink};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne};
use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends Model
{
    use HasFactory, SoftDeletes;

    public function redirectLink(): BelongsTo
    {
        return $this->belongsTo(RedirectLink::class);
    }

    public function value(): HasOne
    {
        return $this->hasOne(ConditionValue::class, 'rule_id');
    }

    public function conditions(): HasMany
    {
        return $this->hasMany(Rule::class, 'owner_id');
    }
}
