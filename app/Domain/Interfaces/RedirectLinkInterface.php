<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Domain\DTO\RuleDto;

interface RedirectLinkInterface
{
    public function getLink(): string;

    /**
     * @return RuleDto[]
     */
    public function getRules(): array;
}
