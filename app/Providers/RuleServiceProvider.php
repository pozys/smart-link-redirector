<?php

namespace App\Providers;

use App\Domain\Models\Rules\LanguageRule;
use Illuminate\Support\ServiceProvider;

class RuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LanguageRule::class . '.provideValue', fn() => static fn(): string => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');
        $this->app->bind(LanguageRule::class . '.castValue', fn() => static fn(mixed $value): string => strtolower((string) $value));
    }

    public function boot(): void
    {
        //
    }
}
