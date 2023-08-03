<?php

namespace Database\Seeders;

use App\Models\CourseRegistration;
use Illuminate\Database\Seeder;

class CourseRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseRegistration::factory()->count(5)->create();
    }
}
