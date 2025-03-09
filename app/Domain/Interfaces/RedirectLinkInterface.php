<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

interface RedirectLinkInterface
{
    public function getLink(): string;

    /**
     * @return RuleInterface[]
     */
    public function getRules(): array;
}
