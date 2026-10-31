<?php

namespace App\Modules\Clients\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Modules\Clients\Models\Client;
use App\Modules\Clients\Contracts\Services\ClientServiceInterface;
use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\DTOs\FilterClientDTO;
use App\Modules\Clients\DTOs\UpdateClientDTO;
use App\Modules\Clients\Http\Requests\FilterClientRequest;
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
        Gate::authorize('create', Client::class);
        $client = $this->clientService->create(
            $request->toDTO()
        );
        return JSONResponse::success(
            $client,
            BuildResponseMessage::create(ResourceEnum::CLIENT),
            201
        );
    }


    public function index(FilterClientRequest $request)
    {
        Gate::authorize('viewAny', Client::class);
        $clients = $this->clientService->list($request->toDTO());
        return JSONResponse::success(
            PublicClientResource::collection($clients),
            BuildResponseMessage::findAll(ResourceEnum::CLIENT),
            200
        );
    }

    public function show(int $id)
    {
        Gate::authorize('view', Client::class);
        $client = $this->clientService->findById($id);
        return JSONResponse::success(
            new PublicClientResource($client),
            BuildResponseMessage::findOne(ResourceEnum::CLIENT),
            200
        );
    }

    public function destroy(int $id)
    {
        Gate::authorize('delete', Client::class);
        $this->clientService->delete($id);
        return JSONResponse::success(
            null,
            BuildResponseMessage::delete(ResourceEnum::CLIENT),
            204
        );
    }

    public function update(UpdateClientRequest $request, int $id){
        Gate::authorize('update', Client::class);
        $client = $this->clientService->update($request->toDTO(), $id);
        return JSONResponse::success(
            new PublicClientResource($client),
            BuildResponseMessage::update(ResourceEnum::CLIENT),
            200
        );
    }
}
