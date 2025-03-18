<?php

declare(strict_types=1);

namespace Tests\Feature\Rules;

use App\Domain\Models\{ConditionValue, Link, RedirectLink};
use App\Domain\Models\Rules\Rule;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\Factories\UserFactory;
use Tests\TestCase;

final class TimeIntervalRuleTest extends TestCase
{
    public function testRuleSuccess(): void
    {
        $gt = now()->addDays(-1);
        $lt = now()->addDays(1);

        $link = Link::factory()
            ->has(RedirectLink::factory())
            ->create();

        $redirectLink = $link->redirectLinks()->first();

        Rule::factory()
            ->for($redirectLink)
            ->has(Rule::factory(2)
                ->state(new Sequence(
                    ['rule_type' => 'LtCondition'],
                    ['rule_type' => 'GtCondition'],
                ))
                ->has(ConditionValue::factory(2)
                    ->state(fn(array $attributes, Rule $rule) =>
                    ['value' => match ($rule->rule_type) {
                        'LtCondition' => $lt,
                        'GtCondition' => $gt,
                    }]), 'value'), 'conditions')
            ->create([
                'rule_type' => 'TimeIntervalRule',
            ]);

        $this->actingAs(UserFactory::make())
            ->get(route('redirect', ['link' => $link->id]))
            ->assertRedirect();
    }

    public function testRuleFail(): void
    {
        $gte = now()->addDays(1);

        $link = Link::factory()
            ->has(RedirectLink::factory())
            ->create();

        $redirectLink = $link->redirectLinks()->first();

        Rule::factory()
            ->for($redirectLink)
            ->has(Rule::factory()
                ->state(['rule_type' => 'GteCondition'])
                ->has(ConditionValue::factory()
                    ->state(
                        ['value' => now()->addDays(1)]
                    ), 'value'), 'conditions')
            ->create([
                'rule_type' => 'TimeIntervalRule',
            ]);

        $this->actingAs(UserFactory::make())
            ->get(route('redirect', ['link' => $link->id]))
            ->assertNotFound();
    }
}
