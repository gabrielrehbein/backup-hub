<?php

namespace App\Modules\Notifications\Services;

use App\Modules\Notifications\Models\Notification;

class NotificationService {
    public function list(): iterable {
        return Notification::all();
    }
}
