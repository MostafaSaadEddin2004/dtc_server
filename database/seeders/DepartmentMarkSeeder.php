<?php

namespace Database\Seeders;

use App\Models\DepartmentMark;
use Illuminate\Database\Seeder;

class DepartmentMarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DepartmentMark::factory()->count(5)->create();
    }
}