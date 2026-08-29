<?php

namespace App\Modules\Backups\Errors;


use Symfony\Component\HttpKernel\Exception\HttpException;


class BackupInFutureHttpException extends HttpException
{
    public function __construct()
    {
        parent::__construct(400, 'O backup não pode ser gerado no futuro.');
    }
}
