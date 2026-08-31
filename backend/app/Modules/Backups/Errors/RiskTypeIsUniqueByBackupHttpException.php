<?php

namespace App\Modules\Backups\Errors;


use Symfony\Component\HttpKernel\Exception\HttpException;


class RiskTypeIsUniqueByBackupHttpException extends HttpException
{
    public function __construct()
    {
        parent::__construct(400, 'O backup pode ter no máximo um tipo de risco ativo.');
    }
}
