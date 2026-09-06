<?php

namespace App\Modules\Backups\Errors;

use Symfony\Component\HttpKernel\Exception\HttpException;

class InstanceNotBelongsToClientHttpException extends HttpException
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct(
            403,
            'A instancia do sistema não pertence ao cliente.'
        );
    }
}
