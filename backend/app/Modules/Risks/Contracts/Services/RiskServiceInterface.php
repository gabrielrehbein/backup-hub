<?php

namespace App\Modules\Risks\Contracts\Services;

use App\Modules\Risks\DTOs\CreateRiskDTO;
use App\Modules\Risks\DTOs\UpdateRiskConfigDTO;
use App\Modules\Risks\Models\Risk;

interface RiskServiceInterface
{
    public function findAll(): iterable;
    public function create(CreateRiskDTO $payload): Risk;
    public function delete(int $id);
    public function findById(int $id): Risk;
    public function update(UpdateRiskConfigDTO $payload, int $id): Risk;
    public function findByPlan(int $planId): iterable;
}
