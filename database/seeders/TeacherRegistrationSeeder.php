<?php

namespace Database\Seeders;

use App\Models\TeacherRegistration;
use Illuminate\Database\Seeder;

class TeacherRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TeacherRegistration::factory()->count(5)->create();
    }
}
