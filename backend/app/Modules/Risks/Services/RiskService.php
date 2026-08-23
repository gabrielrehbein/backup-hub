<?php

namespace App\Modules\Risks\Services;

use App\Modules\Risks\Contracts\Repositories\RiskRepositoryInterface;
use App\Modules\Risks\Contracts\Services\RiskServiceInterface;
use App\Modules\Risks\DTOs\CreateRiskDTO;
use App\Modules\Risks\DTOs\UpdateRiskConfigDTO;
use App\Modules\Risks\Models\Risk;

class RiskService implements RiskServiceInterface
{
    public function __construct(
        private readonly RiskRepositoryInterface $riskRepository,
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
        return $this->riskRepository->findByPlan($planId);
    }

    public function createDefaultRisksForPlan(int $planId): array {
        $defaultRisks = [
            CreateRiskDTO::fromArray([
                'name' => "Baixo",
                "level" => 1,
                'description' => "Risco de impacto baixo",
                'plan_id' => $planId,
                'max_delay_limit_in_minutes' => 2000,
                'max_size_loss_in_percent' => 5,
                'notifiable' => false,
            ]),
            CreateRiskDTO::fromArray([
                'name' => "Medio",
                "level" => 5,
                'description' => "Risco de impacto medio",
                'plan_id' => $planId,
                'max_delay_limit_in_minutes' => 3000,
                'max_size_loss_in_percent' => 8,
                'notifiable' => false,
            ]),
            CreateRiskDTO::fromArray([
                'name' => "Alto",
                "level" => 10,
                'description' => "Risco de impacto alto",
                'plan_id' => $planId,
                'max_delay_limit_in_minutes' => 3000,
                'max_size_loss_in_percent' => 8,
                'notifiable' => true,
            ]),
        ];
        foreach ($defaultRisks as $risk) {
            $this->riskRepository->create($risk);
        }
        return $defaultRisks;
    }
}
