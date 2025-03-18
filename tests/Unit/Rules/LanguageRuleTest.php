<?php

declare(strict_types=1);

namespace Tests\Unit\Rules;

use App\Domain\Interfaces\{ConditionInterface, HasConditionsInterface};
use App\Domain\Models\Rules\LanguageRule;
use Tests\TestCase;
use Closure;
use Illuminate\Database\Eloquent\Model;
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

    public function testShouldReturnTrueWhenAllConditionsAreSatisfied(): void
    {
        $mockRule = $this->createMock(HasConditionsInterface::class);
        $mockCondition1 = $this->createMock(ConditionInterface::class);
        $mockCondition2 = $this->createMock(ConditionInterface::class);

        $mockRule->method('conditions')->willReturn([$mockCondition1, $mockCondition2]);
        $mockCondition1->method('isSatisfied')->willReturn(true);
        $mockCondition2->method('isSatisfied')->willReturn(true);

        $languageRule = new LanguageRule($mockRule);

        $this->assertTrue($languageRule->isSatisfied());
    }

    public function testShouldReturnFalseWhenAtLeastOneConditionIsNotSatisfied(): void
    {
        $mockRule = $this->createMock(HasConditionsInterface::class);
        $mockCondition1 = $this->createMock(ConditionInterface::class);
        $mockCondition2 = $this->createMock(ConditionInterface::class);

        $mockRule->method('conditions')->willReturn([$mockCondition1, $mockCondition2]);
        $mockCondition1->method('isSatisfied')->willReturn(true);
        $mockCondition2->method('isSatisfied')->willReturn(false);

        $languageRule = new LanguageRule($mockRule);

        $this->assertFalse($languageRule->isSatisfied());
    }

    #[DataProvider('emptyData')]
    public function testShouldThrowExceptionWhenLanguageIsNotSet(Closure $varSetter): void
    {
        $varSetter();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('HTTP_ACCEPT_LANGUAGE is not set');

        app('LanguageRule.isSatisfied', [$this->createStub(Model::class)])();
    }
}
