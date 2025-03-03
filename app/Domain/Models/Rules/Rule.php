<?php

declare(strict_types=1);

namespace App\Domain\Models\Rules;

use App\Domain\Interfaces\RuleInterface;
use App\Domain\Models\RedirectLink;
use App\Domain\Traits\HasConditions;
use Database\Factories\Domain\Models\Rules\RuleFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends Model
{
    use HasFactory, HasConditions, SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    protected static function newFactory()
    {
        return RuleFactory::new();
    }

    public function redirectLink(): BelongsTo
    {
        return $this->belongsTo(RedirectLink::class);
    }

    protected function ruleType(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value, array $attributes): RuleInterface => app($value ?? $attributes['rule_type']),
            set: fn(RuleInterface $value) => get_class($value),
        );
    }
}
