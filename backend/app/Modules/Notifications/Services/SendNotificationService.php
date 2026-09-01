<?php

namespace App\Modules\Notifications\Services;

use App\Modules\Notifications\Contracts\Services\NotificationServiceInterface;
use App\Modules\Notifications\Contracts\Strategies\NotifyMethodStrategy;


class SendNotificationService implements NotificationServiceInterface
{
    private array $notificationMethods = [];

    public function __construct(){}

    public function addNotificationMethod(NotifyMethodStrategy $method): void
    {
        $this->notificationMethods[] = $method;
    }

    public function getNotificationMethods(): array
    {
        return $this->notificationMethods;
    }

    public function sendNotifications(): void
    {
        foreach ($this->notificationMethods as $method) {
            $method->send();
        }
    }
}
