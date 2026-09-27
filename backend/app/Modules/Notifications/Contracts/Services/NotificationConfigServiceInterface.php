<?php

namespace App\Modules\Notifications\Contracts\Services;


use App\Modules\Notifications\DTOs\CreateNotificationConfigDTO;
use App\Modules\Notifications\Models\NotificationConfig;


interface NotificationConfigServiceInterface {
    public function save(CreateNotificationConfigDTO $dto): NotificationConfig;
    public function getConfig(): NotificationConfig;
}
