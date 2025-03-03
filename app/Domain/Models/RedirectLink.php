<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\Models\Rules\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\SoftDeletes;

class RedirectLink extends Model
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
}
