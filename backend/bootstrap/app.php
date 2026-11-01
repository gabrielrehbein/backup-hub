<?php

use App\Modules\Backups\Errors\BackupInFutureHttpException;
use App\Modules\Backups\Errors\RiskTypeIsUniqueByBackupHttpException;
use App\Modules\Backups\Errors\InstanceNotBelongsToClientHttpException;
use App\Modules\Systems\NotUniqueClientSystemHttpException;
use App\Modules\Risks\Models\Risk;
use App\Shared\Http\Middleware\CheckInstanceAPIKey;
use App\Shared\Http\Responses\JSONResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withCommands([
        __DIR__.'/../app/Modules/Backups/Console/Commands',
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'instance.auth' => CheckInstanceAPIKey::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        // $exceptions->render(function (NotFoundHttpException $e) {
        //     return JSONResponse::error("Recurso não encontrado", 404);
        // });
        // $exceptions->render(function (BadRequestHttpException $e) {
        //     return JSONResponse::error($e->getMessage());
        // });
        // $exceptions->render(function (TypeError $e) {
        //     return JSONResponse::error("O tipo de dado enviado está incorreto");
        // });
        // $exceptions->render(function (InternalErrorException $e) {
        //     return JSONResponse::error("Algo deu errado");
        // });
        $exceptions->render(function (BackupInFutureHttpException $e) {
            return JSONResponse::error($e->getMessage(), $e->getStatusCode());
        });
        $exceptions->render(function (RiskTypeIsUniqueByBackupHttpException $e) {
            return JSONResponse::error($e->getMessage(), $e->getStatusCode());
        });
        $exceptions->render(function (InstanceNotBelongsToClientHttpException $e) {
            return JSONResponse::error($e->getMessage(), $e->getStatusCode());
        });
        $exceptions->render(function (AccessDeniedHttpException $e) {
            return JSONResponse::error('Você não tem permissão para realizar esta ação.', 403);
        });

        // sem token ou token inválido (auth:sanctum)
        $exceptions->render(function (AuthenticationException $e) {
            return JSONResponse::error('Não autenticado.', 401);
        });

    })->create();
