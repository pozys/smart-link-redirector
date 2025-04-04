<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

interface RedirectLinkInterface
{
    public function getLink(): string;

    /**
     * @return ConditionInterface[]
     */
    public function getRules(): array;
}
