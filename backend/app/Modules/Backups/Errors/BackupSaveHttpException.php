<?php

namespace App\Modules\Backups\Errors;


use Symfony\Component\HttpKernel\Exception\HttpException;


class BackupSaveHttpException extends HttpException
{
    public function __construct()
    {
        parent::__construct(500, 'Algo deu errado ao salvar o backup.');
    }
}
