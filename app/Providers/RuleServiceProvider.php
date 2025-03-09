<?php

namespace App\Providers;

use App\Application\Adapters\RuleInterfaceAdapter;
use App\Domain\Interfaces\ValueWrapperInterface;
use App\Domain\Models\Conditions\{
    AndCondition,
    EqualCondition,
    GtCondition,
    GteCondition,
    LtCondition,
    LteCondition,
    OrCondition
};
use App\Domain\Models\Rules\Rule;
use App\Domain\Models\ValueWrappers\StringValueWrapper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class RuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            'RuleInterface.isSatisfiedBy',
            fn(Application $app, array $args) => static fn(
                ValueWrapperInterface $value
            ): bool => $app->make($args[0]->rule_type . '.isSatisfiedBy', [$app->make(RuleInterfaceAdapter::class, ['adaptee' => $args[0]])])($value)
        );

        $this->app->bind(
            'RuleInterface.ruleType',
            static fn(Application $app, array $args): string => $args[0]->rule_type
        );

        $this->app->bind(
            'RuleInterface.value',
            static fn(Application $app, array $args): mixed => $args[0]->value->value
        );

        $this->app->bind(
            'RuleInterface.conditions',
            static fn(Application $app, array $args): array => $args[0]->conditions->all()
        );

        $this->app->bind(
            'CanProvideExaminedValue.getCurrentValue',
            fn(
                Application $app,
                array $args
            ): ValueWrapperInterface => $app->make(
                $args[0]->rule_type . '.getCurrentValue',
                $args
            )
        );

        $this->app->bind('LanguageRule.getValue', static fn(): string => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');

        $this->app->bind(
            'LanguageRule.getCurrentValue',
            static fn(Application $app, array $args): ValueWrapperInterface => $app->make(
                StringValueWrapper::class,
                ['value' => $app->make($args[0]->rule_type . '.getValue')]
            )
        );

        $this->app->bind(
            'LanguageRule.isSatisfiedBy',
            fn(Application $app, array $args)
            => static fn(ValueWrapperInterface $value): bool => collect($args[0]->conditions())
                ->every(
                    fn(Rule $condition): bool => $app->make('RuleInterface.isSatisfiedBy', [$condition])($value)
                )
        );

        $this->app->bind(
            'EqualCondition.isSatisfiedBy',
            fn(Application $app, array $args) => static fn(
                ValueWrapperInterface $valueWrapper
            ): bool => $app->make(EqualCondition::class)
                ->isValid($valueWrapper->getValue(), $valueWrapper->cast($args[0]->value()))
        );

        $this->app->bind(
            'GteCondition.isSatisfiedBy',
            fn(Application $app, array $args) => static fn(
                ValueWrapperInterface $valueWrapper
            ): bool => $app->make(GteCondition::class)
                ->isValid($valueWrapper->getValue(), $valueWrapper->cast($args[0]->value()))
        );

        $this->app->bind(
            'GtCondition.isSatisfiedBy',
            fn(Application $app, array $args) => static fn(
                ValueWrapperInterface $valueWrapper
            ): bool => $app->make(GtCondition::class)
                ->isValid($valueWrapper->getValue(), $valueWrapper->cast($args[0]->value()))
        );

        $this->app->bind(
            'LteCondition.isSatisfiedBy',
            fn(Application $app, array $args) => static fn(
                ValueWrapperInterface $valueWrapper
            ): bool => $app->make(LteCondition::class)
                ->isValid($valueWrapper->getValue(), $valueWrapper->cast($args[0]->value()))
        );

        $this->app->bind(
            'LtCondition.isSatisfiedBy',
            fn(Application $app, array $args) => static fn(
                ValueWrapperInterface $valueWrapper
            ): bool => $app->make(LtCondition::class)
                ->isValid($valueWrapper->getValue(), $valueWrapper->cast($args[0]->value()))
        );

        $this->app->bind(
            'AndCondition.isSatisfiedBy',
            fn(Application $app, array $args) => static fn(
                ValueWrapperInterface $valueWrapper
            ): bool => $app->make(AndCondition::class)->isValid($valueWrapper, ...$args)
        );

        $this->app->bind(
            'OrCondition.isSatisfiedBy',
            fn(Application $app, array $args) => static fn(
                ValueWrapperInterface $valueWrapper
            ): bool => $app->make(OrCondition::class)->isValid($valueWrapper, ...$args)
        );
    }

    public function boot(): void
    {
        //
    }
}
