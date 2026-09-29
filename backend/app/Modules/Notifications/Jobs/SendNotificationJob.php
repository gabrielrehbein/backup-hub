<?php

namespace App\Modules\Notifications\Jobs;

use App\Modules\Notifications\Contracts\Strategies\NotifyMethodStrategy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly NotifyMethodStrategy $notifyMethod,
    ) {}

    public function handle(): void
    {
        $this->notifyMethod->send();
    }
}
