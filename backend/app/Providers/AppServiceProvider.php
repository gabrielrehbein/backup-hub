<?php

namespace App\Providers;

use App\Modules\Auth\Contracts\Services\AuthServiceInterface;
use App\Modules\Auth\Services\AuthService;
use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\Contracts\Repositories\BackupRiskRepositoryInterface;
use App\Modules\Backups\Contracts\Services\BackupServiceInterface;
use App\Modules\Backups\Contracts\Services\BackupRiskServiceInterface;
use App\Modules\Backups\Models\Backup;
use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Backups\Policies\BackupPolicy;
use App\Modules\Backups\Policies\BackupRiskPolicy;
use App\Modules\Backups\Repositories\BackupEloquentRepository;
use App\Modules\Backups\Repositories\BackupRiskEloquentRepository;
use App\Modules\Backups\Services\BackupService;
use App\Modules\Backups\Services\BackupRiskService;
use App\Modules\Clients\Contracts\Repositories\ClientRepositoryInterface;
use App\Modules\Clients\Contracts\Repositories\PlanRepositoryInterface;
use App\Modules\Clients\Services\ClientService;
use App\Modules\Clients\Contracts\Services\ClientServiceInterface;
use App\Modules\Clients\Contracts\Services\PlanServiceInterface;
use App\Modules\Clients\Repositories\ClientEloquentRepository;
use App\Modules\Clients\Repositories\PlanEloquentRepository;
use App\Modules\Clients\Services\PlanService;

use App\Modules\Risks\Contracts\Repositories\RiskRepositoryInterface;
use App\Modules\Risks\Contracts\Services\RiskServiceInterface;
use App\Modules\Risks\Repositories\RiskEloquentRepository;
use App\Modules\Risks\Services\RiskService;
use App\Modules\Systems\Contracts\Repositories\SystemInstanceRepositoryInterface;
use App\Modules\Systems\Contracts\Repositories\SystemRepositoryInterface;
use App\Modules\Systems\Contracts\Services\SystemInstanceServiceInterface;
use App\Modules\Systems\Contracts\Services\SystemServiceInterface;
use App\Modules\Systems\Repositories\SystemEloquentRepository;
use App\Modules\Systems\Repositories\SystemInstanceEloquentRepository;
use App\Modules\Systems\Services\SystemInstanceService;
use App\Modules\Systems\Services\SystemService;
use App\Modules\Users\Contracts\Repositories\UserRepositoryInterface;
use App\Modules\Users\Contracts\Services\UserServiceInterface;
use App\Modules\Users\Repositories\UserEloquentRepository;
use App\Modules\Users\Services\UserService;
use App\Shared\Security\Actions\UuidApiKeyGenerator;
use App\Shared\Security\Contracts\ApiKeyGeneratorInterface;
use Illuminate\Support\ServiceProvider;
use App\Modules\Clients\Contracts\Services\ClientAuthenticationServiceInterface;
use App\Modules\Clients\Models\Client;
use App\Modules\Clients\Models\Plan;
use App\Modules\Clients\Policies\ClientPolicy;
use App\Modules\Clients\Policies\PlanPolicy;
use App\Modules\Systems\Policies\SystemPolicy;
use App\Modules\Clients\Services\ClientAuthenticationService;

use App\Modules\Dashboard\Contracts\Services\DashboardServiceInterface;
use App\Modules\Dashboard\Services\DashboardService;
use App\Modules\Notifications\Actions\NotifyBackupRiskByMail;
use App\Modules\Notifications\Actions\NotifyBackupWithRisk;
use App\Modules\Notifications\Contracts\Services\NotificationConfigServiceInterface;
use App\Modules\Notifications\Contracts\Services\NotificationServiceInterface;
use App\Modules\Notifications\Contracts\Strategies\Notifiable;
use App\Modules\Notifications\Contracts\Strategies\NotifyMethodStrategy;
use App\Modules\Notifications\Models\Notification;
use App\Modules\Notifications\Models\NotificationConfig;
use App\Modules\Notifications\Policies\NotificationConfigPolicy;
use App\Modules\Notifications\Policies\NotificationPolicy;
use App\Modules\Notifications\Services\NotificationConfigService;
use App\Modules\Notifications\Services\SendNotificationService;
use App\Modules\Risks\Models\Risk;
use App\Modules\Risks\Policies\RiskPolicy;
use App\Modules\Systems\Contracts\Services\SystemInstanceAuthenticationServiceInterface;
use App\Modules\Systems\Models\System;
use App\Modules\Systems\Models\SystemInstance;
use App\Modules\Systems\Policies\SystemInstancePolicy;
use App\Modules\Systems\Services\SystemInstanceAuthenticationService;
use App\Modules\Users\Models\User;
use App\Modules\Users\Policies\UserPolicy;
use App\Shared\Security\Actions\UuidApiKeyWithIdentifierGenerator;

use Illuminate\Support\Facades\Gate;

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
            NotificationConfigServiceInterface::class,
            NotificationConfigService::class
        );

        $this->app->bind(
            RiskServiceInterface::class,
            RiskService::class
        );
        $this->app->bind(
            RiskRepositoryInterface::class,
            RiskEloquentRepository::class
        );

        $this->app->bind(
            ClientServiceInterface::class,
            ClientService::class
        );
        $this->app->bind(
            ClientRepositoryInterface::class,
            ClientEloquentRepository::class
        );
        $this->app->bind(
            ApiKeyGeneratorInterface::class,
            UuidApiKeyWithIdentifierGenerator::class
        );

        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );
        $this->app->bind(
            UserRepositoryInterface::class,
            UserEloquentRepository::class
        );

        $this->app->bind(
            SystemServiceInterface::class,
            SystemService::class
        );
        $this->app->bind(
            SystemRepositoryInterface::class,
            SystemEloquentRepository::class
        );

        $this->app->bind(
            SystemInstanceServiceInterface::class,
            SystemInstanceService::class
        );
        $this->app->bind(
            SystemInstanceRepositoryInterface::class,
            SystemInstanceEloquentRepository::class
        );

        $this->app->bind(
            BackupServiceInterface::class,
            BackupService::class
        );
        $this->app->bind(
            BackupRepositoryInterface::class,
            BackupEloquentRepository::class
        );
        $this->app->bind(
            BackupRiskServiceInterface::class,
            BackupRiskService::class
        );
        $this->app->bind(
            BackupRiskRepositoryInterface::class,
            BackupRiskEloquentRepository::class
        );
        $this->app->bind(
            SystemInstanceAuthenticationServiceInterface::class,
            SystemInstanceAuthenticationService::class
        );

        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );

        $this->app->bind(
            DashboardServiceInterface::class,
            DashboardService::class
        );
        $this->app->bind(
            NotifyMethodStrategy::class,
            NotifyBackupRiskByMail::class
        );
        $this->app->bind(
            NotificationServiceInterface::class,
            SendNotificationService::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Backup::class, BackupPolicy::class);
        Gate::policy(BackupRisk::class, BackupRiskPolicy::class);
        Gate::policy(SystemInstance::class, SystemInstancePolicy::class);
        Gate::policy(System::class, SystemPolicy::class);
        Gate::policy(Client::class, ClientPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Notification::class, NotificationPolicy::class);
        Gate::policy(NotificationConfig::class, NotificationConfigPolicy::class);
        Gate::policy(Risk::class, RiskPolicy::class);
        Gate::policy(Plan::class, PlanPolicy::class);



        Gate::define('uploadBackup', function (
            Client $client,
            SystemInstance $instance
        ): bool {
            return $instance->client_id === $client->id;
        });

    }
}
