<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AcademicRegistration;
use App\Models\Department;
use App\Models\User;

class AcademicRegistrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AcademicRegistration::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'father_name' => $this->faker->word,
            'mother_name' => $this->faker->word,
            'date_of_birth' => $this->faker->date(),
            'place_of_birth' => $this->faker->word,
            'military' => $this->faker->word,
            'current_address' => $this->faker->word,
            'address' => $this->faker->word,
            'name_of_parent' => $this->faker->word,
            'job_of_parent' => $this->faker->word,
            'phone_of_parent' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'phone_of_mother' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'avg_mark' => $this->faker->numberBetween(-10000, 10000),
            'certificate_year' => $this->faker->word,
            'id_image' => $this->faker->word,
            'certificate_image' => $this->faker->word,
            'personal_image' => $this->faker->word,
            'un_image' => $this->faker->word,
            'user_id' => User::factory(),
            'department_id' => Department::factory(),
        ];
    }
}
