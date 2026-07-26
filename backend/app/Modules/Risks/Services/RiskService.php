<?php

namespace App\Modules\Risks\Services;

use App\Modules\Clients\Contracts\Services\PlanServiceInterface;
use App\Modules\Risks\Contracts\Repositories\RiskRepositoryInterface;
use App\Modules\Risks\Contracts\Services\RiskServiceInterface;
use App\Modules\Risks\DTOs\CreateRiskDTO;
use App\Modules\Risks\DTOs\UpdateRiskConfigDTO;
use App\Modules\Risks\Models\Risk;

class RiskService implements RiskServiceInterface
{
    public function __construct(
        private readonly RiskRepositoryInterface $riskRepository,
        private readonly PlanServiceInterface $planService
    ) {}

    public function findAll(): iterable
    {
        return $this->riskRepository->findAll();
    }

    public function findById(int $id): Risk
    {
        return $this->riskRepository->findById($id);
    }

    public function create(CreateRiskDTO $payload): Risk
    {
        return $this->riskRepository->create($payload);
    }

    public function delete(int $id)
    {
        $risk = $this->findById($id);
        return $this->riskRepository->delete($risk);
    }

    public function update(UpdateRiskConfigDTO $payload, int $id): Risk {
        $risk = $this->findById($id);
        return $this->riskRepository->update($payload, $risk);
    }

    public function findByPlan(int $planId): iterable {
        $plan = $this->planService->findById($planId);
        return $this->riskRepository->findByPlan($plan);
    }
}
