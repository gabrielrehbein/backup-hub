<?php

namespace App\Modules\Clients\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Modules\Clients\Models\Plan;
use App\Modules\Clients\Contracts\Services\PlanServiceInterface;
use App\Modules\Clients\DTOs\CreatePlanDTO;
use App\Modules\Clients\DTOs\UpdatePlanDTO;
use App\Modules\Clients\Http\Requests\StorePlanRequest;
use App\Modules\Clients\Http\Requests\UpdatePlanRequest;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;
use App\Shared\Utils\BuildResponseMessage;
use App\Shared\Utils\ResourceEnum;

class PlanController extends Controller
{

    public function __construct(
        protected PlanServiceInterface $planService
    ) {}

    public function store(StorePlanRequest $request)
    {
        Gate::authorize('create', Plan::class);
        $plan = $this->planService->create(
            $request->toDTO()
        );
        return JSONResponse::success(
            $plan,
            BuildResponseMessage::create(ResourceEnum::PLAN),
            201
        );
    }

    public function index()
    {
        Gate::authorize('viewAny', Plan::class);
        $plans = $this->planService->findAll();
        return JSONResponse::success(
            $plans,
            BuildResponseMessage::findAll(ResourceEnum::PLAN),
            200
        );
    }

    public function show(int $id)
    {
        Gate::authorize('view', Plan::class);
        $plan = $this->planService->findById($id);
        return JSONResponse::success(
            $plan,
            BuildResponseMessage::findOne(ResourceEnum::PLAN),
            200
        );
    }

    public function destroy(int $id)
    {
        Gate::authorize('delete', Plan::class);
        $this->planService->delete($id);
        return JSONResponse::success(
            null,
            BuildResponseMessage::delete(ResourceEnum::PLAN),
            204
        );
    }

    public function update(UpdatePlanRequest $request, int $id){
        Gate::authorize('update', Plan::class);
        $planDTO = $request->toDTO();
        $plan = $this->planService->update($planDTO, $id);
        return JSONResponse::success(
            $plan,
            BuildResponseMessage::update(ResourceEnum::PLAN),
            200
        );
    }
}
