<?php

namespace Database\Seeders;

use App\Models\Save;
use Illuminate\Database\Seeder;

class SaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Save::factory()->count(5)->create();
    }
}
