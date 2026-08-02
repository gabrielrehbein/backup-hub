<?php

namespace App\Modules\Systems\Contracts\Services;
use App\Modules\Systems\DTOs\CreateSystemDTO;
use App\Modules\Systems\DTOs\UpdateSystemDTO;
use App\Modules\Systems\Enums\SystemCategoryEnum;
use App\Modules\Systems\Models\System;

interface SystemServiceInterface
{
    public function create(CreateSystemDTO $payload): System;
    public function findAll(): iterable;
    public function delete(int $id): bool;
    public function update(UpdateSystemDTO $payload, int $id): System;
    public function findById(int $id): System;
    public function findByCategory(SystemCategoryEnum $category): iterable;
}
