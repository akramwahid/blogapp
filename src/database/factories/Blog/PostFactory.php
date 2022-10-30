<?php

namespace Database\Factories\Blog;

use App\Models\Blog\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(75),
            'body' => $this->faker->paragraphs(rand(5, 10),true),
            'image' => 'https://picsum.photos/id/'.rand(1,100).'/600/400', //$this->faker->imageUrl(600,400),
            'author_id' => Author::factory()
        ];
    }
}
