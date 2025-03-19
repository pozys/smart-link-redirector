<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\Interfaces\{LinkInterface, RedirectLinkInterface};

interface RedirectLinkRepositoryInterface
{
    /** @return RedirectLinkInterface[] */
    public function findRedirects(LinkInterface $link): array;
}
