<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\Interfaces\LinkInterface;
use App\Domain\Models\Rules\Rule;

interface RedirectLinkRepositoryInterface
{
    /** @return Rule[] */
    public function findRedirects(LinkInterface $link): array;
}
