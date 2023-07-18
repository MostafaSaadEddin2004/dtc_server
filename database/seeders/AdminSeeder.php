<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'role_id' => 1,
            'name' => 'Admin',
            'email' => 'super.admin@admin.com',
        ]);
    }
}
