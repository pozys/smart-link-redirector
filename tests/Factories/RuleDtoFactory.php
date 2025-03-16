<?php

declare(strict_types=1);

namespace Tests\Factories;

use App\Domain\DTO\RuleDto;
use App\Domain\Interfaces\{CanProvideExaminedValue, RuleInterface, ValueWrapperInterface};
use Mockery;

final class RuleDtoFactory
{
    public static function make(bool $isSatisfied = true): RuleDto
    {
        $rule = Mockery::mock(RuleInterface::class);
        $rule->shouldReceive('isSatisfiedBy')->andReturn($isSatisfied);

        $valueProvider = Mockery::mock(CanProvideExaminedValue::class);
        $valueProvider->shouldReceive('getCurrentValue')->andReturn(Mockery::mock(ValueWrapperInterface::class));

        return app(RuleDto::class, compact('rule', 'valueProvider'));
    }
}
