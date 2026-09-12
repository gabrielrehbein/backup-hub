<?php

namespace App\Modules\Clients\Seeders;

use App\Modules\Clients\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name' => 'Premium',
        ]);

        Plan::create([
            'name' => 'Básico',
        ]);
    }
}

