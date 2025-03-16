<?php

declare(strict_types=1);

namespace Tests\Unit\Rules;

use Tests\TestCase;
use Illuminate\Contracts\Foundation\Application;
use App\Providers\RuleServiceProvider;
use App\Domain\Models\Rules\Rule;
use App\Domain\Models\Conditions\EqualCondition;
use App\Domain\Models\ValueWrappers\StringValueWrapper;
use Closure;
use PHPUnit\Framework\Attributes\DataProvider;

class LanguageRuleTest extends TestCase
{
    public static function emptyData(): array
    {
        return [
            [static fn() => $_SERVER['HTTP_ACCEPT_LANGUAGE'] = null],
            [function () {
                unset($_SERVER['HTTP_ACCEPT_LANGUAGE']);
            }],
        ];
    }


    // public function testRuleDoesNotMatchWithoutAcceptLanguageHeader(): void
    // {
    //     $rule = $this->makeRule('en');

    //     $this->assertFalse($this->ruleChecker->satisfies($rule));
    // }

    #[DataProvider('emptyData')]
    public function testShouldHandleEmptyHttpAcceptLanguageServerVariable(Closure $varSetter): void
    {
        $varSetter();

        $this->assertEmpty($this->app->make('LanguageRule.getValue'));
    }
}
