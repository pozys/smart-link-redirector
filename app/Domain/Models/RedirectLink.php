<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Application\Adapters\ConditionInterfaceAdapter;
use App\Domain\Interfaces\{ConditionInterface, RedirectLinkInterface};
use App\Domain\Models\Rules\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RedirectLink extends Model implements RedirectLinkInterface
{
    use HasFactory, SoftDeletes;

    public function rules(): MorphMany
    {
        return $this->morphMany(Rule::class, 'owned');
    }

    public function getLink(): string
    {
        return $this->url;
    }

    /**
     * @return ConditionInterface[]
     */
    public function getRules(): array
    {
        return $this->rules->mapInto(ConditionInterfaceAdapter::class)->all();
    }
}
