<?php

namespace App\Modules\Clients\Http\Controllers;

use App\Modules\Clients\DTOs\CreatePlanDTO;
use App\Modules\Clients\Http\Requests\StorePlanRequest;
use App\Modules\Clients\Models\Plan;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;

class PlanController extends Controller
{
    public function create(StorePlanRequest $request)
    {
        $planDTO = CreatePlanDTO::fromArray($request->validated());
        $plan = Plan::create($planDTO->toArray());
        return JSONResponse::success($plan, 'Plano criado com sucesso', 201);
    }

    public function index()
    {
        $plans = Plan::all();
        return JSONResponse::success($plans, 'Planos recuperados com sucesso');
    }

    public function show(Plan $plan)
    {
        return JSONResponse::success($plan, 'Plano recuperado com sucesso');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return JSONResponse::success(null, 'Plano deletado com sucesso');
    }
}
