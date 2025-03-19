<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Application\Interfaces\RedirectLinkRepositoryInterface;
use App\Domain\Interfaces\{LinkInterface, RedirectLinkInterface};

final class DatabaseRedirectLinkRepository implements RedirectLinkRepositoryInterface
{
    /** @return RedirectLinkInterface[] */
    public function findRedirects(LinkInterface $link): array
    {
        return $link->redirectLinks->all();
    }
}
