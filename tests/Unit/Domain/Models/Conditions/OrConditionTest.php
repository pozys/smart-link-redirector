<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Models\Conditions;

use App\Domain\Interfaces\{ConditionInterface, HasConditionsInterface};
use App\Domain\Models\Conditions\OrCondition;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class OrConditionTest extends TestCase
{
    public static function satisfiedData(): array
    {
        return [
            [true, false],
            [false, true],
            [true, true],
        ];
    }

    #[DataProvider('satisfiedData')]
    public function testIsSatisfied(bool ...$results): void
    {
        $condition = app(OrCondition::class, ['condition' => $this->stubConditionsProvider(...$results), 'examinedValue' => 'foo']);

        $this->assertTrue($condition->isSatisfied());
    }

    public function testIsNotSatisfied(): void
    {
        $condition = app(OrCondition::class, ['condition' => $this->stubConditionsProvider(false, false), 'examinedValue' => 'foo']);

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
