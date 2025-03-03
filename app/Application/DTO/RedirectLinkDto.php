<?php

declare(strict_types=1);

namespace App\Application\DTO;

class RedirectLinkDto
{
    /**
     * @param RuleDto[]|null $rules
     */
    public function __construct(
        public readonly ?int $id = null,
        public readonly string $url,
        public readonly ?array $rules = null
    ) {}
}
