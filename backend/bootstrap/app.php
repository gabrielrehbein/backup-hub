<?php

use App\Shared\Http\Responses\JSONResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Shared\Http\Middleware\CheckClientAPIKey;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'client.auth' => CheckClientAPIKey::class,
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

    })->create();
