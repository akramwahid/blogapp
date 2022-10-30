<?php

namespace Database\Factories\Blog;

use App\Models\Blog\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'message' => $this->faker->text(rand(150, 400)),
            'post_id' => Post::factory()
        ];
    }
}
