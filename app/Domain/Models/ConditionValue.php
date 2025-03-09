<?php

namespace App\Domain\Models;

use App\Domain\Models\Rules\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConditionValue extends Model
{
    use HasFactory, SoftDeletes;

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Rule::class, 'rule_id');
    }
}
