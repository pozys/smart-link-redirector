<?php

declare(strict_types=1);

namespace App\Domain\Models\Rules;

use App\Domain\Interfaces\{ConditionInterface, HasConditionsInterface};

final class LanguageRule
{
    public function __construct(private readonly HasConditionsInterface $rule) {}

    public static function provideValue(): string
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            throw new \Exception('HTTP_ACCEPT_LANGUAGE is not set');
        }

        return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }

    public function isSatisfied(): bool
    {
        return collect($this->rule->conditions())
            ->every(fn(ConditionInterface $condition): bool => $condition->isSatisfied());
    }
}
