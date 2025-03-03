<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\Interfaces\{LinkInterface, RedirectLinkInterface};

interface RedirectResolverInterface
{
    public function resolve(LinkInterface $link): ?RedirectLinkInterface;
}
