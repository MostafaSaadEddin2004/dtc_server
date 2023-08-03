<?php

namespace Database\Seeders;

use App\Models\PostType;
use Illuminate\Database\Seeder;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['department', 'course', 'public'] as $value) {
            PostType::create([
                'name' => $value,
            ]);
        }
    }
}
