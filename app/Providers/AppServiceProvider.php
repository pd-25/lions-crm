<?php

namespace App\Providers;

use App\core\member\MemberInterface;
use App\core\member\MemberRepository;
use App\core\operationschemes\OperationSchemeInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(MemberInterface::class, MemberRepository::class);
        $this->app->bind(OperationSchemeInterface::class, \App\core\operationschemes\OperationSchemeRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
