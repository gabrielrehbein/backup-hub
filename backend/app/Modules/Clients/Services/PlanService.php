<?php

namespace App\Modules\Clients\Services;

use App\Modules\Clients\Contracts\Repositories\PlanRepositoryInterface;
use App\Modules\Clients\Contracts\Services\PlanServiceInterface;
use App\Modules\Clients\DTOs\CreatePlanDTO;
use App\Modules\Clients\DTOs\UpdatePlanDTO;
use App\Modules\Clients\Models\Plan;
use App\Modules\Risks\Contracts\Services\RiskServiceInterface;


class PlanService implements PlanServiceInterface
{
    public function __construct(
        private readonly PlanRepositoryInterface $planRepository,
        private readonly RiskServiceInterface $riskService
    ){}

    public function create(CreatePlanDTO $payload): Plan
    {
        $plan = $this->planRepository->create($payload);

        $this->riskService->createDefaultRisksForPlan($plan->id);

        return $plan;
    }

    public function findAll(): iterable
    {
        return $this->planRepository->findAll();
    }

    public function delete(int $id): bool
    {
        $plan = $this->findById($id);

        return $this->planRepository->delete($plan);
    }

    public function update(UpdatePlanDTO $payload, int $id): Plan
    {
        $plan = $this->findById($id);

        return $this->planRepository->update($payload, $plan);
    }

    public function findById(int $id): Plan
    {
        return $this->planRepository->findById($id);
    }
}
