<?php

namespace App\Providers;

use App\Application\Interfaces\{ComparatorInterface, RedirectResolverInterface, RuleCheckerInterface};
use App\Application\Services\{RedirectResolver, RuleChecker, StrictComparator};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RuleCheckerInterface::class, RuleChecker::class);
        $this->app->bind(ComparatorInterface::class, StrictComparator::class);
        $this->app->bind(RedirectResolverInterface::class, RedirectResolver::class);
    }

    public function boot(): void
    {
        //
    }
}
