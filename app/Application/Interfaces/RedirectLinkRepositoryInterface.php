<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Application\DTO\RedirectLinkDto;
use App\Domain\Interfaces\LinkInterface;
use App\Domain\Models\Rules\Rule;

interface RedirectLinkRepositoryInterface
{
    /** @return Rule[] */
    public function findRedirects(LinkInterface $link): array;

    public function save(RedirectLinkDto $redirect): void;
}
