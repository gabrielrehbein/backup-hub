<?php

namespace App\Shared\Http\Middleware;

use App\Modules\Systems\Contracts\Services\SystemInstanceAuthenticationServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Shared\Http\Responses\JSONResponse;



class CheckInstanceAPIKey
{
    public function __construct(
        private readonly SystemInstanceAuthenticationServiceInterface $instanceAuthService
    ) {}
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');

        if (empty($apiKey)) {
            return JSONResponse::error(
                'API Key é obrigatória.',
                400
            );
        }

        $instance = $this->instanceAuthService->isValidAPIKey($apiKey);

        if (!$instance) {
            return JSONResponse::error('A chave de API é inválida.', 401);
        }

        $request->attributes->set('instance', $instance);
        return $next($request);
    }
}
