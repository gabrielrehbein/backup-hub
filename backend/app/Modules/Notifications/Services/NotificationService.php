<?php

namespace App\Modules\Notifications\Services;

use App\Modules\Notifications\Models\Notification;

class NotificationService {
    public function list(): iterable {
        return Notification::orderBy('created_at', 'desc')->get();
    }

    public function findById(int $id): Notification {
        return Notification::findOrFail($id);
    }
}
