<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Application\Interfaces\RedirectLinkRepositoryInterface;
use App\Domain\Interfaces\LinkInterface;

final class DatabaseRedirectLinkRepository implements RedirectLinkRepositoryInterface
{
    public function findRedirects(LinkInterface $link): array
    {
        return $link->redirectLinks->all();
    }
}
