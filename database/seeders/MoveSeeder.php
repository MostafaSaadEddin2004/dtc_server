<?php

namespace Database\Seeders;

use App\Models\Move;
use Illuminate\Database\Seeder;

class MoveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Move::factory()->count(5)->create();
    }
}
