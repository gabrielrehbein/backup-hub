<?php

namespace App\Modules\Notifications\Contracts\Services;

use App\Modules\Notifications\Contracts\Strategies\NotifyMethodStrategy;


interface NotificationServiceInterface
{
    public function sendNotifications(): void;
    public function addNotificationMethod(NotifyMethodStrategy $notificationMethod): void;
}
