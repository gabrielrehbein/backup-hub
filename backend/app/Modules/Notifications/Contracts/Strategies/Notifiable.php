<?php

namespace App\Modules\Notifications\Contracts\Strategies;

interface Notifiable
{
    public function send(mixed $content);
}
