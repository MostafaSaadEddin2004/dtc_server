<?php

namespace Database\Seeders;

use App\Models\AcademicRegistration;
use Illuminate\Database\Seeder;

class AcademicRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicRegistration::factory()->count(5)->create();
    }
}
