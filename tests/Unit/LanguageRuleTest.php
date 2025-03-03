<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Application\Interfaces\RuleCheckerInterface;
use App\Domain\Models\Conditions\{Condition, EqualCondition};
use App\Domain\Models\{ConditionValue, Link, RedirectLink};
use App\Domain\Models\Rules\Rule;
use Tests\TestCase;

final class LanguageRuleTest extends TestCase
{
    private RuleCheckerInterface $ruleChecker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ruleChecker = app(RuleCheckerInterface::class);
    }

    public function testRuleMatchesSuccessfully(): void
    {
        $expectedLanguage = 'en';

        $rule = $this->makeRule($expectedLanguage);

        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = $expectedLanguage;

        $this->assertTrue($this->ruleChecker->isApplicable($rule));
    }

    public function testRuleDoesNotMatch(): void
    {
        $rule = $this->makeRule('en');

        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'ru';

        $this->assertFalse($this->ruleChecker->isApplicable($rule));
    }

    public function testRuleDoesNotMatchWithoutAcceptLanguageHeader(): void
    {
        $rule = $this->makeRule('en');

        $this->assertFalse($this->ruleChecker->isApplicable($rule));
    }

    private function makeRule(string $language): Rule
    {
        return Rule::factory()
            ->has(
                Condition::factory()->state(['condition_type' => app(EqualCondition::class)])
                    ->has(ConditionValue::factory()->state(['value' => $language])),
                'conditions'
            )
            ->for(RedirectLink::factory()
                ->for(Link::factory()))
            ->create();
    }
}
