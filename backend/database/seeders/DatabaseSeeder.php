<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Clients\Seeders\ClientSeeder;
use App\Modules\Clients\Seeders\PlanSeeder;
use App\Modules\Risks\Seeders\RiskSeeder;
use App\Modules\Systems\Seeders\CategorySeeder;
use App\Modules\Systems\Seeders\SystemInstanceSeeder;
use App\Modules\Systems\Seeders\SystemSeeder;
use App\Modules\Users\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            SystemSeeder::class,
            PlanSeeder::class,
            RiskSeeder::class,
            ClientSeeder::class,
            UserSeeder::class,
        ]);
    }
}
