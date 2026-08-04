<?php

namespace App\Modules\Clients\Http\Controllers;

use App\Modules\Clients\Contracts\Services\ClientServiceInterface;
use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\DTOs\UpdateClientDTO;
use App\Modules\Clients\Http\Requests\StoreClientRequest;
use App\Modules\Clients\Http\Requests\UpdateClientRequest;
use App\Modules\Clients\Http\Resources\PublicClientResource;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;
use App\Shared\Utils\BuildResponseMessage;
use App\Shared\Utils\ResourceEnum;


class ClientController extends Controller
{

    public function __construct(
        protected ClientServiceInterface  $clientService
    ) {}

    public function store(StoreClientRequest $request)
    {
        $clientWithUnhashedApiKeyDTO = $this->clientService->create(
            $request->toDTO()
        );
        return JSONResponse::success(
            $clientWithUnhashedApiKeyDTO,
            BuildResponseMessage::create(ResourceEnum::CLIENT),
            201
        );
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
        return JSONResponse::success(
            PublicClientResource::collection($clients),
            BuildResponseMessage::findAll(ResourceEnum::CLIENT),
            200
        );
    }

    public function show(int $id)
    {
        $client = $this->clientService->findById($id);
        return JSONResponse::success(
            new PublicClientResource($client),
            BuildResponseMessage::findOne(ResourceEnum::CLIENT),
            200
        );
    }

    public function destroy(int $id)
    {
        $this->clientService->delete($id);
        return JSONResponse::success(
            null,
            BuildResponseMessage::delete(ResourceEnum::CLIENT),
            204
        );
    }

    public function update(UpdateClientRequest $request, int $id){
        $client = $this->clientService->update($request->toDTO(), $id);
        return JSONResponse::success(
            new PublicClientResource($client),
            BuildResponseMessage::update(ResourceEnum::CLIENT),
            200
        );
    }
}
