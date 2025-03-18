<?php

declare(strict_types=1);

namespace Tests\Feature\Rules;

use App\Domain\Models\{ConditionValue, Link, RedirectLink};
use App\Domain\Models\Rules\Rule;
use Tests\Factories\UserFactory;
use Tests\TestCase;

final class LanguageRuleTest extends TestCase
{
    public function testRuleSuccess(): void
    {
        $expected = 'en';

        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = $expected;

        $link = Link::factory()
            ->has(RedirectLink::factory())
            ->create();

        $redirectLink = $link->redirectLinks()->first();

        Rule::factory()
            ->for($redirectLink)
            ->has(Rule::factory()
                ->state(['rule_type' => 'EqualCondition'])
                ->has(ConditionValue::factory()
                    ->state(['value' => $expected]), 'value'), 'conditions')
            ->create([
                'rule_type' => 'LanguageRule',
            ]);

        $this->actingAs(UserFactory::make())
            ->get(route('redirect', ['link' => $link->id]))
            ->assertRedirect();
    }

    public function testRuleFail(): void
    {
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'en';

        $link = Link::factory()
            ->has(RedirectLink::factory())
            ->create();

        $redirectLink = $link->redirectLinks()->first();

        Rule::factory()
            ->for($redirectLink)
            ->has(Rule::factory()
                ->state(['rule_type' => 'EqualCondition'])
                ->has(ConditionValue::factory()
                    ->state(['value' => 'fr']), 'value'), 'conditions')
            ->create([
                'rule_type' => 'LanguageRule',
            ]);

        $this->actingAs(UserFactory::make())
            ->get(route('redirect', ['link' => $link->id]))
            ->assertNotFound();
    }
}
