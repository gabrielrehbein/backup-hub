<?php

namespace App\Modules\Clients\Errors;


use Symfony\Component\HttpKernel\Exception\HttpException;


class InvalidApiKeyHttpException extends HttpException
{
    public function __construct()
    {
        parent::__construct(401, 'API Key inválida');
    }
}
