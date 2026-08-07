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
        $externalClientId = $request->input('external_client_id');

        if (empty($apiKey) || empty($externalClientId)) {
            return JSONResponse::error(
                'API Key e external_client_id são obrigatórios.',
                400
            );
        }

        if (!$this->clientAuthService->isValidAPIKey($externalClientId, $apiKey)) {
            return JSONResponse::error('A chave de API é inválida.', 401);
        }

        return $next($request);
    }
}
