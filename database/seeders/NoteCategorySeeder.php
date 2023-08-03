<?php

namespace Database\Seeders;

use App\Models\NoteCategory;
use Illuminate\Database\Seeder;

class NoteCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NoteCategory::factory()->count(5)->create();
    }
}
