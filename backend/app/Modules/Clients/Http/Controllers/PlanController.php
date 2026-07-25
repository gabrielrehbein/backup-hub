<?php

namespace App\Modules\Clients\Http\Controllers;

use App\Modules\Clients\Contracts\Services\PlanServiceInterface;
use App\Modules\Clients\DTOs\CreatePlanDTO;
use App\Modules\Clients\DTOs\UpdatePlanDTO;
use App\Modules\Clients\Http\Requests\StorePlanRequest;
use App\Modules\Clients\Http\Requests\UpdatePlanRequest;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;



class PlanController extends Controller
{

    public function __construct(
        protected PlanServiceInterface $planService
    ) {}

    public function store(StorePlanRequest $request)
    {
        $plan = $this->planService->create(
            CreatePlanDTO::fromArray($request->toArray())
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
        return JSONResponse::success(null, 'Plano deletado com sucesso');
    }

    public function update(UpdatePlanRequest $request, int $id){
        $planDTO = UpdatePlanDTO::fromArray($request->validated());
        $plan = $this->planService->update($planDTO, $id);
        return JSONResponse::success($plan, "Plano modificado com sucesso");
    }
}
