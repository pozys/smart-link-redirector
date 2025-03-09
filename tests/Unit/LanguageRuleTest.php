<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Application\Interfaces\RuleCheckerInterface;
use App\Domain\Models\{ConditionValue, Link, RedirectLink};
use App\Domain\Models\Rules\Rule;
use Tests\TestCase;

final class LanguageRuleTest extends TestCase
{
    private readonly RuleCheckerInterface $ruleChecker;

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

        $this->assertTrue($this->ruleChecker->satisfies($rule));
    }

    public function testRuleDoesNotMatch(): void
    {
        $rule = $this->makeRule('en');

        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'ru';

        $this->assertFalse($this->ruleChecker->satisfies($rule));
    }

    public function testRuleDoesNotMatchWithoutAcceptLanguageHeader(): void
    {
        $rule = $this->makeRule('en');

        $this->assertFalse($this->ruleChecker->satisfies($rule));
    }

    private function makeRule(string $language): Rule
    {
        $link = Link::factory()->create();
        $redirectLink = RedirectLink::factory()->for($link)->create();

        return Rule::factory()
            ->for($redirectLink)
            ->has(
                Rule::factory()->state(['rule_type' => 'EqualCondition'])
                    ->has(ConditionValue::factory()->state(['value' => $language]), 'value'),
                'conditions'
            )
            ->create();
    }
}
