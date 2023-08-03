<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\DepartmentMark;

class DepartmentMarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DepartmentMark::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'mark' => $this->faker->numberBetween(-10000, 10000),
            'year' => $this->faker->numberBetween(-10000, 10000),
            'department_id' => Department::factory(),
        ];
    }
}
