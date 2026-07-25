<?php

namespace App\Providers;

use App\Modules\Clients\Contracts\Repositories\PlanRepositoryInterface;
use App\Modules\Clients\Contracts\Services\PlanServiceInterface;
use App\Modules\Clients\Repositories\PlanEloquentRepository;
use App\Modules\Clients\Services\PlanService;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
