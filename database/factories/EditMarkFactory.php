<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EditMark;
use App\Models\Teacher;
use App\Models\User;

class EditMarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EditMark::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->word,
            'mark' => $this->faker->numberBetween(-10000, 10000),
            'reason' => $this->faker->word,
            'teacher_id' => Teacher::factory(),
            'user_id' => User::factory(),
        ];
    }
}
