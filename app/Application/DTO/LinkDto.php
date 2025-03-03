<?php

declare(strict_types=1);

namespace App\Application\DTO;

class LinkDto
{
    public function __construct(public readonly ?int $id = null, public readonly string $url) {}
}
