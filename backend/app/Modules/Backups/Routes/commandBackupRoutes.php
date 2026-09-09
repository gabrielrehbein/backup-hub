<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('backup:analyze')
    ->everyMinute()
    ->withoutOverlapping();
