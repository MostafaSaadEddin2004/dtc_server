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
            'first_name_en' => 'Admin',
            'last_name_en' => 'Admin',
            'first_name_ar' => 'Admin',
            'last_name_ar' => 'Admin',
            'email' => 'super.admin@admin.com',
            'password' => '12345678',
            'is_admin' => 1,
        ]);
    }
}
