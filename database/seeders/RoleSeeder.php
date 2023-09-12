<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
        ]);

        Role::create([
            'name' => 'student_browser',
        ]);

        Role::create([
            'name' => 'teacher_browser',
        ]);

        Role::create([
            'name' => 'student',
        ]);

        Role::create([
            'name' => '4',
        ]);
    }
}
