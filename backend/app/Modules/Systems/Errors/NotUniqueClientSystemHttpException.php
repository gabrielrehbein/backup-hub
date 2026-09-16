<?php

namespace App\Modules\Systems\Errors;


use Symfony\Component\HttpKernel\Exception\HttpException;


class NotUniqueClientSystemHttpException extends HttpException
{
    public function __construct()
    {
        parent::__construct(400, 'Cliente já possui uma instância deste sistema');
    }
}
