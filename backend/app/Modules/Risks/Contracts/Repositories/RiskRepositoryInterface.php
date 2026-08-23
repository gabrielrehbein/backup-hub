<?php

namespace App\Modules\Risks\Contracts\Repositories;

use App\Modules\Clients\Models\Plan;
use App\Modules\Risks\DTOs\CreateRiskDTO;
use App\Modules\Risks\DTOs\UpdateRiskConfigDTO;
use App\Modules\Risks\Models\Risk;


interface RiskRepositoryInterface
{
    public function findAll(): iterable;
    public function create(CreateRiskDTO $payload): Risk;
    public function delete(Risk $risk);
    public function findById(int $id): Risk;
    public function update(UpdateRiskConfigDTO $payload, Risk $risk): Risk;
    public function findByPlan(int $planId): iterable;
}
