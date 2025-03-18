<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Models\Conditions;

use App\Domain\Interfaces\CanProvideValueInterface;
use App\Domain\Models\Conditions\GteCondition;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class GteConditionTest extends TestCase
{
    public static function rightData(): array
    {
        return [
            'string-equal' => ['foo', 'foo'],
            'string-greater' => ['foo', 'bar'],
            'integer-equal' => [1, 1],
            'integer-greater' => [4, 1],
            'float-equal' => [1.1, 1.1],
            'float-greater' => [1.2, 1.1],
            'bool-equal' => [true, true],
            'bool-greater' => [true, false],
            'date-equal' => [Carbon::parse('2022-01-01'), Carbon::parse('2022-01-01')],
            'date-greater' => [Carbon::parse('2022-02-01'), Carbon::parse('2022-01-01')],
        ];
    }

    public static function wrongData(): array
    {
        return [
            'string' => ['bar', 'foo'],
            'integer' => [1, 2],
            'float' => [1.1, 1.2],
            'bool' => [false, true],
            'date' => [Carbon::parse('2022-01-01'), Carbon::parse('2022-01-02')],
        ];
    }

    #[DataProvider('rightData')]
    public function testIsSatisfied(mixed $value, mixed $limit): void
    {
        $condition = $this->createStub(CanProvideValueInterface::class);
        $condition->method('getValue')->willReturn($limit);

        $this->assertTrue(app(GteCondition::class, compact('condition', 'value'))->isSatisfied());
    }

    #[DataProvider('wrongData')]
    public function testIsNotSatisfied(mixed $value, mixed $limit): void
    {
        $condition = $this->createStub(CanProvideValueInterface::class);
        $condition->method('getValue')->willReturn($limit);

        $this->assertFalse(app(GteCondition::class, compact('condition', 'value'))->isSatisfied());
    }
}
