<?php

namespace App\Modules\Clients\Errors;


use Symfony\Component\HttpKernel\Exception\HttpException;


class ClientInactiveHttpException extends HttpException
{
    public function __construct()
    {
        parent::__construct(403, 'Cliente está inativo');
    }
}
