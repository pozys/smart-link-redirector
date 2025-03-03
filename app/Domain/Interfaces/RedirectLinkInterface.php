<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use Illuminate\Support\Collection;

interface RedirectLinkInterface
{
    public function getLink(): string;

    /**
     * @return Collection<CanProvideExaminedValue>
     */
    public function getRules(): Collection;
}
