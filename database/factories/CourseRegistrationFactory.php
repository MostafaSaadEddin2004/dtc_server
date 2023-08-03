<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\User;

class CourseRegistrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseRegistration::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'is_male' => $this->faker->boolean,
            'social_status' => $this->faker->word,
            'nationality' => $this->faker->word,
            'address' => $this->faker->word,
            'date_of_birth' => $this->faker->date(),
            'student_type' => $this->faker->word,
            'work_type' => $this->faker->word,
            'is_morning' => $this->faker->boolean,
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
        ];
    }
}
