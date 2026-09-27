<?php

namespace App\Modules\Notifications\Services;

use App\Modules\Notifications\Contracts\Services\NotificationConfigServiceInterface;
use App\Modules\Notifications\DTOs\CreateNotificationConfigDTO;
use App\Modules\Notifications\Models\NotificationConfig;

class NotificationConfigService implements NotificationConfigServiceInterface {
    public function save(CreateNotificationConfigDTO $dto): NotificationConfig {
        $notificationConfig = NotificationConfig::first();
        if(!$notificationConfig){
            return NotificationConfig::create([
                "email" => $dto->email,
            ]);
        }

        $notificationConfig->email = $dto->email;
        $notificationConfig->save();

        return $notificationConfig;
    }
}
