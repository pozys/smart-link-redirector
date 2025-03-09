<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Models\Conditions;

use App\Domain\Interfaces\RuleInterface;
use App\Domain\Models\ValueWrappers\StringValueWrapper;
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
        $condition = app('AndCondition.isSatisfiedBy', $this->stubConditions(true, true));

        $this->assertTrue($condition(app(StringValueWrapper::class, ['value' => 'foo'])));
    }

    #[DataProvider('notSatisfiedData')]
    public function testIsNotSatisfied(bool ...$results): void
    {
        $condition = app('AndCondition.isSatisfiedBy', $this->stubConditions(...$results));

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
