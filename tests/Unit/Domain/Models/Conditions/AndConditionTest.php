<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Models\Conditions;

use App\Domain\Interfaces\{ConditionInterface, HasConditionsInterface};
use App\Domain\Models\Conditions\AndCondition;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class AndConditionTest extends TestCase
{
    public static function notSatisfiedData(): array
    {
        return [
            [true, false],
            [false, true],
            [false, false],
        ];
    }

    public function testIsSatisfied(): void
    {
        $condition = app(AndCondition::class, ['condition' => $this->stubConditionsProvider(true, true), 'examinedValue' => 'foo']);

        $this->assertTrue($condition->isSatisfied());
    }

    #[DataProvider('notSatisfiedData')]
    public function testIsNotSatisfied(bool ...$results): void
    {
        $condition = app(AndCondition::class, ['condition' => $this->stubConditionsProvider(...$results), 'examinedValue' => 'foo']);

        $this->assertFalse($condition->isSatisfied());
    }

    private function stubConditionsProvider(bool ...$results): HasConditionsInterface
    {
        $stub = $this->createStub(HasConditionsInterface::class);
        $stub->method('conditions')
            ->willReturn(collect($results)->map(fn(bool $result): ConditionInterface => $this->stubCondition($result))->all());

        return $stub;
    }

    private function stubCondition(bool $isSatisfied = true): ConditionInterface
    {
        $stub = $this->createStub(ConditionInterface::class);
        $stub->method('isSatisfied')->willReturn($isSatisfied);

        return $stub;
    }
}
