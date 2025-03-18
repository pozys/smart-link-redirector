<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Models\Conditions;

use App\Domain\Interfaces\CanProvideValueInterface;
use App\Domain\Models\Conditions\GtCondition;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class GtConditionTest extends TestCase
{
    public static function rightData(): array
    {
        return [
            'string' => ['foo', 'bar'],
            'integer' => [2, 1],
            'float' => [1.2, 1.1],
            'bool' => [true, false],
            'date' => [Carbon::parse('2022-01-02'), Carbon::parse('2022-01-01')],
        ];
    }

    public static function wrongData(): array
    {
        return [
            'string-equal' => ['foo', 'foo'],
            'string-greater' => ['bar', 'foo'],
            'integer-equal' => [1, 1],
            'integer-greater' => [1, 2],
            'float-equal' => [1.1, 1.1],
            'float-greater' => [1.1, 1.2],
            'bool-equal' => [true, true],
            'bool-greater' => [false, true],
            'date-equal' => [Carbon::parse('2022-01-01'), Carbon::parse('2022-01-01')],
            'date-greater' => [Carbon::parse('2022-01-01'), Carbon::parse('2022-01-02')],
        ];
    }

    #[DataProvider('rightData')]
    public function testIsSatisfied(mixed $value, mixed $limit): void
    {
        $condition = $this->createStub(CanProvideValueInterface::class);
        $condition->method('getValue')->willReturn($limit);

        $this->assertTrue(app(GtCondition::class, compact('condition', 'value'))->isSatisfied());
    }

    #[DataProvider('wrongData')]
    public function testIsNotSatisfied(mixed $value, mixed $limit): void
    {
        $condition = $this->createStub(CanProvideValueInterface::class);
        $condition->method('getValue')->willReturn($limit);

        $this->assertFalse(app(GtCondition::class, compact('condition', 'value'))->isSatisfied());
    }
}
