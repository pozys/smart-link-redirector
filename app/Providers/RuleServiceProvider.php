<?php

namespace App\Providers;

use App\Application\Adapters\{CanProvideValueAdapter, HasConditionsInterfaceAdapter};
use App\Domain\Models\Conditions\{
    AndCondition,
    EqualCondition,
    GtCondition,
    GteCondition,
    LtCondition,
    LteCondition,
    OrCondition
};
use App\Domain\Models\Rules\{LanguageRule, TimeIntervalRule};
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class RuleServiceProvider extends ServiceProvider
{
    private array $conditionBindings = [
        'Equal' => EqualCondition::class,
        'Gt' => GtCondition::class,
        'Lt' => LtCondition::class,
        'Gte' => GteCondition::class,
        'Lte' => LteCondition::class,
        'Or' => OrCondition::class,
        'And' => AndCondition::class,
    ];

    public function register(): void
    {
        $this->bindConditionInterface();
        $this->bindLanguageRule();
        $this->bindTimeIntervalRule();
        $this->bindConditions();
    }

    private function bindConditionInterface(): void
    {
        $this->app->bind(
            'ConditionInterface.isSatisfied',
            fn(Application $app, $args) => static fn(): bool => $app->make($args[0]->rule_type . '.isSatisfied', $args)()
        );
    }

    private function bindLanguageRule(): void
    {
        $this->app->bind(
            'LanguageRule.isSatisfied',
            fn(Application $app, array $args) => static fn(): bool => $app->make(
                LanguageRule::class,
                ['rule' => app(HasConditionsInterfaceAdapter::class, ['adaptee' => $args[0], 'value' => LanguageRule::provideValue()])]
            )->isSatisfied()
        );
    }

    private function bindTimeIntervalRule(): void
    {
        $this->app->bind(
            'TimeIntervalRule.isSatisfied',
            fn(Application $app, array $args) => static fn(): bool => $app->make(
                TimeIntervalRule::class,
                ['rule' => app(HasConditionsInterfaceAdapter::class, ['adaptee' => $args[0], 'value' => TimeIntervalRule::provideValue()])]
            )->isSatisfied()
        );
    }

    private function bindConditions(): void
    {
        foreach ($this->conditionBindings as $conditionName => $conditionClass) {
            $this->bindCondition($conditionName, $conditionClass);
        }
    }

    private function bindCondition(string $conditionName, string $conditionClass): void
    {
        $this->app->bind(
            $conditionName . 'Condition.isSatisfied',
            fn(Application $app, array $args) => fn(): bool => $app->make(
                $conditionClass,
                $this->getConditionParameters($conditionName, $args)
            )->isSatisfied()
        );
    }

    private function getConditionParameters(string $conditionName, array $args): array
    {
        return in_array($conditionName, ['Or', 'And'])
            ? ['rule' => app(HasConditionsInterfaceAdapter::class, ['adaptee' => $args[0]]), 'value' => $args[1]]
            : ['condition' => $this->app->make(CanProvideValueAdapter::class, ['adaptee' => $args[0]]), 'value' => $args[1]];
    }

    public function boot(): void
    {
        //
    }
}
