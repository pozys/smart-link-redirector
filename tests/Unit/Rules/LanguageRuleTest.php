<?php

declare(strict_types=1);

namespace Tests\Unit\Rules;

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

    #[DataProvider('emptyData')]
    public function testShouldThrowExceptionWhenLanguageIsNotSet(Closure $varSetter): void
    {
        $varSetter();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('HTTP_ACCEPT_LANGUAGE is not set');

        app('LanguageRule.isSatisfied', [$this->createStub(Model::class)])();
    }
}
