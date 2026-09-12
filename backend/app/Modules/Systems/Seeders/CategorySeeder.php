<?php

namespace App\Modules\Systems\Seeders;

use App\Modules\Systems\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'ERP',
        ]);

        Category::create([
            'name' => 'Sistema Fiscal',
        ]);

        Category::create([
            'name' => 'Backup',
        ]);
    }
}
