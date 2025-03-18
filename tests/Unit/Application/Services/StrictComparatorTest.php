<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Services;

use App\Application\Services\StrictComparator;
use App\Domain\Interfaces\ConditionInterface;
use Tests\TestCase;

final class StrictComparatorTest extends TestCase
{
    public function testReturnsTrueWhenAllRulesAreSatisfied()
    {
        $strictComparator = app(StrictComparator::class);

        $result = $strictComparator->isApplicable($this->stubCondition(true), $this->stubCondition(true));

        $this->assertTrue($result);
    }

    public function testIReturnsFalseWhenAnyRuleIsNotSatisfied()
    {
        $strictComparator = app(StrictComparator::class);

        $result = $strictComparator->isApplicable($this->stubCondition(false), $this->stubCondition(true));

        $this->assertFalse($result);
    }

    public function testReturnsTrueWhenNoRulesAreProvided()
    {
        $strictComparator = app(StrictComparator::class);

        $result = $strictComparator->isApplicable();

        $this->assertTrue($result);
    }

    private function stubCondition(bool $isSatisfied = true): ConditionInterface
    {
        $condition = $this->createStub(ConditionInterface::class);
        $condition->method('isSatisfied')->willReturn($isSatisfied);

        return $condition;
    }
}
