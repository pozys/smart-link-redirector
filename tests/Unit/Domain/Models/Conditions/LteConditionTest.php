<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Models\Conditions;

use App\Domain\Interfaces\CanProvideValueInterface;
use App\Domain\Models\Conditions\LteCondition;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class LteConditionTest extends TestCase
{
    public static function rightData(): array
    {
        return [
            'string-equal' => ['foo', 'foo'],
            'string-less' => ['bar', 'foo'],
            'integer-equal' => [1, 1],
            'integer-less' => [1, 2],
            'float-equal' => [1.1, 1.1],
            'float-less' => [1.1, 1.2],
            'bool-equal' => [true, true],
            'bool-less' => [false, true],
            'date-equal' => [Carbon::parse('2022-01-01'), Carbon::parse('2022-01-01')],
            'date-less' => [Carbon::parse('2022-01-01'), Carbon::parse('2022-02-01')]
        ];
    }

    public static function wrongData(): array
    {
        return [
            'string' => ['foo', 'bar'],
            'integer' => [4, 1],
            'float' => [1.2, 1.1],
            'bool' => [true, false],
            'date-less' => [Carbon::parse('2022-02-01'), Carbon::parse('2022-01-01')]
        ];
    }

    #[DataProvider('rightData')]
    public function testIsSatisfied(mixed $value, mixed $limit): void
    {
        $condition = $this->createStub(CanProvideValueInterface::class);
        $condition->method('getValue')->willReturn($limit);

        $this->assertTrue(app(LteCondition::class, compact('condition', 'value'))->isSatisfied());
    }

    #[DataProvider('wrongData')]
    public function testIsNotSatisfied(mixed $value, mixed $limit): void
    {
        $condition = $this->createStub(CanProvideValueInterface::class);
        $condition->method('getValue')->willReturn($limit);

        $this->assertFalse(app(LteCondition::class, compact('condition', 'value'))->isSatisfied());
    }
}
