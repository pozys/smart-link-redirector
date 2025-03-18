<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\Interfaces\LinkInterface;
use Illuminate\Database\Eloquent\Model;

interface RedirectLinkRepositoryInterface
{
    /** @return Model[] */
    public function findRedirects(LinkInterface $link): array;
}
