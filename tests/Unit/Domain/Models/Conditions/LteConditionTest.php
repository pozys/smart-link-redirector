<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Models\Conditions;

use App\Domain\Interfaces\{RuleInterface, ValueWrapperInterface};
use App\Domain\Models\ValueWrappers\{
    BooleanValueWrapper,
    DateTimeValueWrapper,
    FloatValueWrapper,
    IntegerValueWrapper,
    StringValueWrapper
};
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class LteConditionTest extends TestCase
{
    public static function rightData(): array
    {
        return [
            'string-equal' => [app(StringValueWrapper::class, ['value' => 'foo']), 'foo'],
            'string-less' => [app(StringValueWrapper::class, ['value' => 'bar']), 'foo'],
            'integer-equal' => [app(IntegerValueWrapper::class, ['value' => '1']), '1'],
            'integer-less' => [app(IntegerValueWrapper::class, ['value' => '1']), '2'],
            'float-equal' => [app(FloatValueWrapper::class, ['value' => '1.1']), '1.1'],
            'float-less' => [app(FloatValueWrapper::class, ['value' => '1.1']), '1.2'],
            'bool-equal' => [app(BooleanValueWrapper::class, ['value' => 'true']), 'true'],
            'bool-less' => [app(BooleanValueWrapper::class, ['value' => 'false']), 'true'],
            'date-equal' => [app(DateTimeValueWrapper::class, ['value' => '2022-01-01']), '2022-01-01'],
            'date-less' => [app(DateTimeValueWrapper::class, ['value' => '2022-01-01']), '2022-02-01'],
        ];
    }

    public static function wrongData(): array
    {
        return [
            'string' => [app(StringValueWrapper::class, ['value' => 'foo']), 'bar'],
            'integer' => [app(IntegerValueWrapper::class, ['value' => '4']), '1'],
            'float' => [app(FloatValueWrapper::class, ['value' => '1.2']), '1.1'],
            'bool' => [app(BooleanValueWrapper::class, ['value' => 'true']), 'false'],
            'date' => [app(DateTimeValueWrapper::class, ['value' => '2022-02-01']), '2022-01-01'],
        ];
    }

    #[DataProvider('rightData')]
    public function testIsSatisfied(ValueWrapperInterface $actual, string $limit): void
    {
        $condition = app('LteCondition.isSatisfiedBy', [$this->wrapIntoRuleInerface($limit)]);

        $this->assertTrue($condition($actual));
    }

    #[DataProvider('wrongData')]
    public function testIsNotSatisfied(ValueWrapperInterface $actual, string $limit): void
    {
        $condition = app('LteCondition.isSatisfiedBy', [$this->wrapIntoRuleInerface($limit)]);

        $this->assertFalse($condition($actual));
    }

    private function wrapIntoRuleInerface(mixed $value): RuleInterface
    {
        $stub = $this->createStub(RuleInterface::class);
        $stub->method('value')->willReturn($value);

        return $stub;
    }
}
