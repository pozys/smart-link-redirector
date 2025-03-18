<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Models\Conditions;

use App\Domain\Interfaces\CanProvideValueInterface;
use App\Domain\Models\Conditions\EqualCondition;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class EqualConditionTest extends TestCase
{
    public static function rightData(): array
    {
        return [
            'string' => ['foo', 'foo'],
            'integer' => [1, 1],
            'float' => [1.1, 1.1],
            'bool' => [true, true],
            'date' => [Carbon::parse('2022-01-01'), Carbon::parse('2022-01-01')],
        ];
    }

    public static function wrongData(): array
    {
        return [
            'string' => ['foo', 'bar'],
            'integer' => [1, 2],
            'float' => [1.1, 1.2],
            'bool' => [true, false],
            'date' => [Carbon::parse('2022-01-01'), Carbon::parse('2022-01-02')],
        ];
    }

    #[DataProvider('rightData')]
    public function testIsSatisfied(mixed $value, mixed $expect): void
    {
        $condition = $this->createStub(CanProvideValueInterface::class);
        $condition->method('getValue')->willReturn($expect);

        $this->assertTrue(app(EqualCondition::class, compact('condition', 'value'))->isSatisfied());
    }

    #[DataProvider('wrongData')]
    public function testIsNotSatisfied(mixed $value, mixed $expect): void
    {
        $condition = $this->createStub(CanProvideValueInterface::class);
        $condition->method('getValue')->willReturn($expect);

        $this->assertFalse(app(EqualCondition::class, compact('condition', 'value'))->isSatisfied());
    }
}
