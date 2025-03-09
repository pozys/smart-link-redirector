<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Models\Conditions;

use App\Domain\Interfaces\RuleInterface;
use App\Domain\Models\ValueWrappers\StringValueWrapper;
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
        $condition = app('OrCondition.isSatisfiedBy', $this->stubConditions(...$results));

        $this->assertTrue($condition(app(StringValueWrapper::class, ['value' => 'foo'])));
    }

    public function testIsNotSatisfied(): void
    {
        $condition = app('OrCondition.isSatisfiedBy', $this->stubConditions(false, false));

        $this->assertFalse($condition(app(StringValueWrapper::class, ['value' => 'foo'])));
    }

    private function stubConditions(bool ...$results): array
    {
        return collect($results)->map(fn(bool $result): RuleInterface => $this->stubCondition($result))->all();
    }

    private function stubCondition(bool $result): RuleInterface
    {
        $stub = $this->createStub(RuleInterface::class);
        $stub->method('isSatisfiedBy')->willReturn($result);

        return $stub;
    }
}
