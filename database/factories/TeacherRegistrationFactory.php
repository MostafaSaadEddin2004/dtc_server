<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\TeacherRegistration;

class TeacherRegistrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeacherRegistration::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'certificate' => $this->faker->word,
            'speciality' => $this->faker->word,
            'date_of_birth' => $this->faker->date(),
            'current_address' => $this->faker->word,
            'address' => $this->faker->word,
            'department_id' => Department::factory(),
        ];
    }
}
