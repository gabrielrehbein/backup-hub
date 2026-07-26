<?php

namespace App\Modules\Clients\Errors;


use Symfony\Component\HttpKernel\Exception\HttpException;


class ClientNotFoundHttpException extends HttpException
{
    public function __construct()
    {
        parent::__construct(404, 'Cliente não encontrado');
    }
}
