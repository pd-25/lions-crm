<?php

namespace App\Providers;

use App\core\bookingregister\BookingRegisterInterface;
use App\core\bookingregister\BookingRegisterRepository;
use App\core\expenditure\ExpenditureInterface;
use App\core\expenditure\ExpenditureRepository;
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
        $this->app->bind(BookingRegisterInterface::class, BookingRegisterRepository::class);
        $this->app->bind(ExpenditureInterface::class, ExpenditureRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
