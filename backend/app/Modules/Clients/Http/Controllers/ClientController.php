<?php

namespace App\Modules\Clients\Http\Controllers;

use App\Modules\Clients\Contracts\Services\ClientServiceInterface;
use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\DTOs\UpdateClientDTO;
use App\Modules\Clients\Http\Requests\StoreClientRequest;
use App\Modules\Clients\Http\Requests\UpdateClientRequest;
use App\Modules\Clients\Http\Resources\ClientWithApiKeyResource;
use App\Modules\Clients\Http\Resources\PublicClientResource;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;


class ClientController extends Controller
{

    public function __construct(
        protected ClientServiceInterface  $clientService
    ) {}

    public function store(StoreClientRequest $request)
    {
        $clientWithUnhashedApiKeyDTO = $this->clientService->create(
            CreateClientDTO::fromArray($request->toArray())
        );
        return JSONResponse::success($clientWithUnhashedApiKeyDTO, 'Cliente criado com sucesso', 201);
    }

    public function refreshApiKey(int $id)
    {
        $apiKey = $this->clientService->refreshApiKey(
            $id
        );
        return JSONResponse::success(["new_api_key" => $apiKey], 'Api Key atualizada com sucesso');
    }

    public function index()
    {
        $clients = $this->clientService->findAll();
        return JSONResponse::success(PublicClientResource::collection($clients), 'Clientes recuperados com sucesso');
    }

    public function show(int $id)
    {
        $client = $this->clientService->findById($id);
        return JSONResponse::success(new PublicClientResource($client), 'Cliente recuperado com sucesso');
    }

    public function destroy(int $id)
    {
        $this->clientService->delete($id);
        return JSONResponse::success(null, 'Cliente deletado com sucesso', 204);
    }

    public function update(UpdateClientRequest $request, int $id){
        $clientDTO = UpdateClientDTO::fromArray($request->validated());
        $client = $this->clientService->update($clientDTO, $id);
        return JSONResponse::success(new PublicClientResource($client), "Cliente modificado com sucesso");
    }
}
