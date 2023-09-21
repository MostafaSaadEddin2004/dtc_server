<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'certificate' => $this->faker->name,
            'specialty' => $this->faker->name,
            'birth_date' => $this->faker->date,
            'current_location' => $this->faker->name,
            'permanent_location' => $this->faker->name,
            'nationality' => $this->faker->name,
            'section_id' => Section::factory(),
        ];
    }
}
