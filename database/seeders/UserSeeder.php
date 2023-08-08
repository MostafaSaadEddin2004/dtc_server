<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Student borwsers
        User::factory(5)->create(['role_id' => 2]);

        // Teacher borwsers
        User::factory(5)->create(['role_id' => 3]);

        // Students
        User::factory(5)->create(['role_id' => 4]);

        // Teachers
        User::factory(5)->create(['role_id' => 5]);

        User::factory()->create([
            'role_id' => 2,
            'email' => 'my@example.com',
        ]);
    }
}
