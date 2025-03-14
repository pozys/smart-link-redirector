<?php

namespace App\Providers;

use App\Application\Interfaces\{
    ComparatorInterface,
    RedirectLinkRepositoryInterface,
    RedirectResolverInterface,
    RuleCheckerInterface
};
use App\Application\Services\{RedirectResolver, RuleChecker, StrictComparator};
use App\Domain\Interfaces\LinkInterface;
use App\Domain\Models\Link;
use App\Infrastructure\Repositories\RemoteRedirectLinkRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RuleCheckerInterface::class, RuleChecker::class);
        $this->app->bind(ComparatorInterface::class, StrictComparator::class);
        $this->app->bind(RedirectResolverInterface::class, RedirectResolver::class);
        $this->app->bind(LinkInterface::class, Link::class);
        $this->app->bind(RedirectLinkRepositoryInterface::class, RemoteRedirectLinkRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
