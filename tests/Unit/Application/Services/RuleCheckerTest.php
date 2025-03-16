<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Services;

use App\Application\Services\RuleChecker;
use Tests\Factories\RuleDtoFactory;
use Tests\TestCase;

final class RuleCheckerTest extends TestCase
{
    public function testSatisfiesReturnsTrueWhenRuleIsSatisfied()
    {
        $ruleDto = RuleDtoFactory::make(true);

        $ruleChecker = app(RuleChecker::class);

        $result = $ruleChecker->satisfies($ruleDto);

        $this->assertTrue($result);
    }

    public function testSatisfiesReturnsFalseWhenRuleIsNotSatisfied()
    {
        $ruleDto = RuleDtoFactory::make(false);

        $ruleChecker = app(RuleChecker::class);

        $result = $ruleChecker->satisfies($ruleDto);

        $this->assertFalse($result);
    }
}
