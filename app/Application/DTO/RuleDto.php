<?php

declare(strict_types=1);

namespace App\Application\DTO;

class RuleDto
{
    /**
     * @param ConditionValueDto[]|null $conditionValues
     */
    public function __construct(
        public readonly string $name,
        public readonly ?array $conditionValues = null
    ) {}
}
