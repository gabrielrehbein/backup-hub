<?php

namespace App\Modules\Systems\Seeders;

use App\Modules\Systems\Models\System;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    public function run(): void
    {
        System::create([
            'name' => 'Sistema A',
            'category_id' => 1,
        ]);

        System::create([
            'name' => 'Sistema B',
            'category_id' => 2,
        ]);

        System::create([
            'name' => 'Sistema C',
            'category_id' => 2,
        ]);
    }
} 
