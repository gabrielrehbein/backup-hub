<?php

namespace App\Modules\Notifications\Services;

use App\Modules\Notifications\Contracts\Strategies\NotifiableStrategy;

class SendNotificationService
{
    private array $notificationMethods = [];

    public function __construct(
        NotifiableStrategy $notifiable
    ){
        $this->notificationMethods[] = $notifiable;
    }

    public function addNotificationMethod(NotifiableStrategy $notifiable): void
    {
        $this->notificationMethods[] = $notifiable;
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
