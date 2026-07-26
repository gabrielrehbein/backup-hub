<?php

namespace App\Providers;

use App\Modules\Clients\Contracts\Repositories\PlanRepositoryInterface;
use App\Modules\Clients\Contracts\Services\PlanServiceInterface;
use App\Modules\Clients\Repositories\PlanEloquentRepository;
use App\Modules\Clients\Services\PlanService;

use App\Modules\Risks\Contracts\Repositories\RiskRepositoryInterface;
use App\Modules\Risks\Contracts\Services\RiskServiceInterface;
use App\Modules\Risks\Repositories\RiskEloquentRepository;
use App\Modules\Risks\Services\RiskService;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PlanServiceInterface::class,
            PlanService::class
        );
        $this->app->bind(
            PlanRepositoryInterface::class,
            PlanEloquentRepository::class
        );

        $this->app->bind(
            RiskServiceInterface::class,
            RiskService::class
        );
        $this->app->bind(
            RiskRepositoryInterface::class,
            RiskEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
