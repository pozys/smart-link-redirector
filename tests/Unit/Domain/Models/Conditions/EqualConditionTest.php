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

final class EqualConditionTest extends TestCase
{
    public static function rightData(): array
    {
        return [
            'string' => [app(StringValueWrapper::class, ['value' => 'foo']), 'foo'],
            'integer' => [app(IntegerValueWrapper::class, ['value' => '1']), '1'],
            'float' => [app(FloatValueWrapper::class, ['value' => '1.1']), '1.1'],
            'bool' => [app(BooleanValueWrapper::class, ['value' => 'true']), 'true'],
            'date' => [app(DateTimeValueWrapper::class, ['value' => '2022-01-01']), '2022-01-01'],
        ];
    }

    public static function wrongData(): array
    {
        return [
            'string' => [app(StringValueWrapper::class, ['value' => 'foo']), 'bar'],
            'integer' => [app(IntegerValueWrapper::class, ['value' => '1']), '2'],
            'float' => [app(FloatValueWrapper::class, ['value' => '1.1']), '1.2'],
            'bool' => [app(BooleanValueWrapper::class, ['value' => 'true']), 'false'],
            'date' => [app(DateTimeValueWrapper::class, ['value' => '2022-01-01']), '2022-01-02'],
        ];
    }

    #[DataProvider('rightData')]
    public function testIsSatisfied(ValueWrapperInterface $actual, string $expected): void
    {
        $equalCondition = app('EqualCondition.isSatisfiedBy', [$this->wrapIntoRuleInerface($expected)]);

        $this->assertTrue($equalCondition($actual));
    }

    #[DataProvider('wrongData')]
    public function testIsNotSatisfied(ValueWrapperInterface $actual, string $expected): void
    {
        $equalCondition = app('EqualCondition.isSatisfiedBy', [$this->wrapIntoRuleInerface($expected)]);

        $this->assertFalse($equalCondition($actual));
    }

    private function wrapIntoRuleInerface(mixed $value): RuleInterface
    {
        $stub = $this->createStub(RuleInterface::class);
        $stub->method('value')->willReturn($value);

        return $stub;
    }
}
