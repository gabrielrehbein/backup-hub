<?php

namespace App\Modules\Systems\Seeders;


use App\Modules\Systems\Models\SystemInstance;
use Illuminate\Database\Seeder;

class SystemInstanceSeeder extends Seeder
{
    public function run(): void
    {
        SystemInstance::create([
            'client_id' => 1,
            'system_id' => 1,
            "version" => "1.0.0",
        ]);

        SystemInstance::create([
            'client_id' => 2,
            'system_id' => 2,
            "version" => "1.0.0",
        ]);
    }
}
