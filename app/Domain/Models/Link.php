<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\Interfaces\LinkInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Link extends Model implements LinkInterface
{
    use HasFactory, SoftDeletes, HasUuids;

    public function redirectLinks(): HasMany
    {
        return $this->hasMany(RedirectLink::class);
    }
}
