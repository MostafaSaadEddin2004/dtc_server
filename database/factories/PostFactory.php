<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Department;
use App\Models\Post;
use App\Models\PostType;
use App\Models\User;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraphs(3, true),
            'attachment' => $this->faker->word,
            'attachment_type' => $this->faker->word,
            'user_id' => User::factory(),
            'department_id' => Department::factory(),
            'course_id' => Course::factory(),
            'post_type_id' => PostType::factory(),
        ];
    }
}
