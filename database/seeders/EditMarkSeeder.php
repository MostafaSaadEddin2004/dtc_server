<?php

namespace Database\Seeders;

use App\Models\EditMark;
use Illuminate\Database\Seeder;

class EditMarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EditMark::factory()->count(5)->create();
    }
}
