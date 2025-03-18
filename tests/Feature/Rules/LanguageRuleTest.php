<?php

declare(strict_types=1);

namespace Tests\Feature\Rules;

use App\Domain\Models\{ConditionValue, Link, RedirectLink};
use App\Domain\Models\Rules\Rule;
use App\Infrastructure\Http\Middleware\AuthenticateService;
use Tests\Factories\UserFactory;
use Tests\TestCase;

final class LanguageRuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(AuthenticateService::class);
    }

    public function testRuleSuccess(): void
    {
        $expected = 'en';

        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = $expected;

        $link = Link::factory()
            ->has(RedirectLink::factory()->count(1))
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
}
