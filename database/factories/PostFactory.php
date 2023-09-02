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
        $attachment_types = ['image', 'file'];
        return [
            'content' => $this->faker->text,
            'attachment' => $this->faker->word,
            'attachment_type' => $attachment_types[rand(0, 1)],
            'user_id' => User::factory(),
            'department_id' => Department::factory(),
            'course_id' => Course::factory(),
            'post_type_id' => rand(1, PostType::count()),
        ];
    }
}
