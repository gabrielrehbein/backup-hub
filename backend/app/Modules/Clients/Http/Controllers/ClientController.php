<?php

namespace App\Modules\Clients\Http\Controllers;

use App\Modules\Clients\Contracts\Services\ClientServiceInterface;
use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\DTOs\UpdateClientDTO;
use App\Modules\Clients\Http\Requests\StoreClientRequest;
use App\Modules\Clients\Http\Requests\UpdateClientRequest;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;


class PlanController extends Controller
{

    public function __construct(
        protected ClientServiceInterface  $planService
    ) {}

    public function store(StoreClientRequest $request)
    {
        $plan = $this->planService->create(
            CreateClientDTO::fromArray($request->toArray())
        );
        return JSONResponse::success($plan, 'Plano criado com sucesso', 201);
    }

    public function index()
    {
        $plans = $this->planService->findAll();
        return JSONResponse::success($plans, 'Planos recuperados com sucesso');
    }

    public function show(int $id)
    {
        $plan = $this->planService->findById($id);
        return JSONResponse::success($plan, 'Plano recuperado com sucesso');
    }

    public function destroy(int $id)
    {
        $this->planService->delete($id);
        return JSONResponse::success(null, 'Plano deletado com sucesso', 204);
    }

    public function update(UpdateClientRequest $request, int $id){
        $planDTO = UpdateClientDTO::fromArray($request->validated());
        $plan = $this->planService->update($planDTO, $id);
        return JSONResponse::success($plan, "Plano modificado com sucesso");
    }
}
