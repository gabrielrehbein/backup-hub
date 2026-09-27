<?php


namespace App\Modules\Notifications\DTOs;

class CreateNotificationConfigDTO
{
    public function __construct(
        public string $email,
    ) {
    }
}
