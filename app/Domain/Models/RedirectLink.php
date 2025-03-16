<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Application\Adapters\{CanProvideExaminedValueAdapter, RuleInterfaceAdapter};
use App\Domain\DTO\RuleDto;
use App\Domain\Interfaces\RedirectLinkInterface;
use App\Domain\Models\Rules\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\SoftDeletes;

class RedirectLink extends Model implements RedirectLinkInterface
{
    use HasFactory, SoftDeletes;

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

    public function rules(): HasMany
    {
        return $this->hasMany(Rule::class);
    }

    public function getLink(): string
    {
        return $this->url;
    }

    /**
     * @return RuleDto[]
     */
    public function getRules(): array
    {
        return $this->rules->map(
            fn(Rule $rule): RuleDto => app(RuleDto::class, [
                app(RuleInterfaceAdapter::class, ['adaptee' => $rule]),
                app(CanProvideExaminedValueAdapter::class, ['adaptee' => $rule])
            ])
        );
    }
}
