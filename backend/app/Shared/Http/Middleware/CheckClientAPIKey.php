<?php

namespace App\Shared\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Shared\Http\Responses\JSONResponse;
use App\Modules\Clients\Contracts\Services\ClientAuthenticationServiceInterface;

class CheckClientAPIKey
{
    public function __construct(
        private readonly ClientAuthenticationServiceInterface $clientAuthService
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

        $client = $this->clientAuthService->isValidAPIKey($apiKey);

        if (!$client) {
            return JSONResponse::error('A chave de API é inválida.', 401);
        }

        $request->attributes->set('client', $client);
        return $next($request);
    }
}
