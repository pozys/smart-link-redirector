<?php

declare(strict_types=1);

namespace App\Domain\Models\ValueWrappers;

use App\Domain\Interfaces\ValueWrapperInterface;
use DateTime;
use Illuminate\Support\Carbon;

final class DateTimeValueWrapper implements ValueWrapperInterface
{
    public function __construct(private readonly string $value) {}

    public function getValue(): DateTime
    {
        return $this->cast($this->value);
    }

    public function cast(string $value): DateTime
    {
        return Carbon::parse($value);
    }
}
