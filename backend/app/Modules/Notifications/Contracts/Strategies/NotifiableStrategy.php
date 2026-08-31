<?php

namespace App\Modules\Notifications\Contracts\Strategies;

interface NotifiableStrategy
{
    public function send();
}
