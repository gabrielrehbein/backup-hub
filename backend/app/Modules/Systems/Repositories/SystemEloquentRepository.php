<?php

namespace App\Modules\Systems\Repositories;

use App\Modules\Systems\Contracts\Repositories\SystemRepositoryInterface;
use App\Modules\Systems\DTOs\CreateSystemDTO;
use App\Modules\Systems\DTOs\UpdateSystemDTO;
use App\Modules\Systems\Enums\SystemCategoryEnum;
use App\Modules\Systems\Models\System;

class SystemEloquentRepository implements SystemRepositoryInterface
{
    public function create(CreateSystemDTO $payload): System
    {
        return System::create($payload->toArray());
    }

    public function findAll(): iterable
    {
        return System::all();
    }

    public function delete(System $system): bool
    {
        return $system->delete();
    }

    public function update(UpdateSystemDTO $payload, System $system): System
    {
        $system = $system->fill($payload->toArray());
        if ($system->isDirty()) {
            $system->save();
        }
        return $system;
    }

    public function findById(int $id): System
    {
        return System::findOrFail($id);
    }

    public function findByCategory(SystemCategoryEnum $category): iterable
    {
        return System::where('category', $category->value)->get();
    }
}
