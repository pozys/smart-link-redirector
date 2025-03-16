<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Services;

use App\Application\Interfaces\RuleCheckerInterface;
use App\Application\Services\StrictComparator;
use App\Domain\DTO\RuleDto;
use App\Domain\Interfaces\{CanProvideExaminedValue, RuleInterface};
use Tests\TestCase;

final class StrictComparatorTest extends TestCase
{
    public function testReturnsTrueWhenAllRulesAreSatisfied()
    {
        $ruleChecker = $this->createStub(RuleCheckerInterface::class);
        $ruleChecker->method('satisfies')->willReturnOnConsecutiveCalls(true, true);

        $strictComparator = app(StrictComparator::class, compact('ruleChecker'));

        $result = $strictComparator->isApplicable($this->stubRuleDto(), $this->stubRuleDto());

        $this->assertTrue($result);
    }

    public function testIReturnsFalseWhenAnyRuleIsNotSatisfied()
    {
        $ruleChecker = $this->createStub(RuleCheckerInterface::class);
        $ruleChecker->method('satisfies')->willReturnOnConsecutiveCalls(true, false);

        $strictComparator = app(StrictComparator::class, compact('ruleChecker'));

        $result = $strictComparator->isApplicable($this->stubRuleDto(), $this->stubRuleDto());

        $this->assertFalse($result);
    }

    public function testReturnsTrueWhenNoRulesAreProvided()
    {
        $ruleChecker = $this->createStub(RuleCheckerInterface::class);

        $strictComparator = app(StrictComparator::class, compact('ruleChecker'));

        $result = $strictComparator->isApplicable();

        $this->assertTrue($result);
    }

    private function stubRuleDto(): RuleDto
    {
        $rule = $this->createStub(RuleInterface::class);
        $valueProvider = $this->createStub(CanProvideExaminedValue::class);

        return app(RuleDto::class, compact('rule', 'valueProvider'));
    }
}
