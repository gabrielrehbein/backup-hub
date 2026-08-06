<?php


namespace App\Modules\Backups\Enums;

enum SizeTypeEnum: string
{
    case KB = 'kb';
    case MB = 'mb';
    case GB = 'gb';
}
