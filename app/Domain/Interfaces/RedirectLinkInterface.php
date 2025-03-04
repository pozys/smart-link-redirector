<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use Illuminate\Support\Collection;

interface RedirectLinkInterface
{
    public function getLink(): string;

    /**
     * @return array<CanProvideExaminedValue>
     */
    public function getRules(): array;
}
