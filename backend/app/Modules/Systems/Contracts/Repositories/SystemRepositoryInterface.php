<?php

namespace App\Modules\Systems\Contracts\Repositories;

use App\Modules\Systems\DTOs\CreateSystemDTO;
use App\Modules\Systems\DTOs\UpdateSystemDTO;
use App\Modules\Systems\Enums\SystemCategoryEnum;
use App\Modules\Systems\Models\System;

interface SystemRepositoryInterface
{
    public function create(CreateSystemDTO $payload): System;
    public function findAll(): iterable;
    public function delete(System $system): bool;
    public function update(UpdateSystemDTO $payload, System $system): System;
    public function findById(int $id): System;
    public function findByCategory(int $categoryId): iterable;
}
