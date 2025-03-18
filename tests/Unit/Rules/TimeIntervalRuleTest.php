<?php

declare(strict_types=1);

namespace Tests\Unit\Rules;

use App\Domain\Interfaces\{ConditionInterface, HasConditionsInterface};
use App\Domain\Models\Rules\TimeIntervalRule;
use Tests\TestCase;

class TimeIntervalRuleTest extends TestCase
{
    public function testReturnsTrueWhenAllConditionsAreSatisfied()
    {
        $mockCondition1 = $this->createMock(ConditionInterface::class);
        $mockCondition1->method('isSatisfied')->willReturn(true);

        $mockCondition2 = $this->createMock(ConditionInterface::class);
        $mockCondition2->method('isSatisfied')->willReturn(true);

        $mockRule = $this->createMock(HasConditionsInterface::class);
        $mockRule->method('conditions')->willReturn([$mockCondition1, $mockCondition2]);

        $timeIntervalRule = new TimeIntervalRule($mockRule);

        $this->assertTrue($timeIntervalRule->isSatisfied());
    }

    public function testReturnsFalseWhenAtLeastOneConditionIsNotSatisfied()
    {
        $mockCondition1 = $this->createMock(ConditionInterface::class);
        $mockCondition1->method('isSatisfied')->willReturn(true);

        $mockCondition2 = $this->createMock(ConditionInterface::class);
        $mockCondition2->method('isSatisfied')->willReturn(false);

        $mockRule = $this->createMock(HasConditionsInterface::class);
        $mockRule->method('conditions')->willReturn([$mockCondition1, $mockCondition2]);

        $timeIntervalRule = new TimeIntervalRule($mockRule);

        $this->assertFalse($timeIntervalRule->isSatisfied());
    }
}
