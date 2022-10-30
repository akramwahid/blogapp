<?php

namespace Database\Seeders;

use App\Models\Blog\Author;
use App\Models\Blog\Post;
use Illuminate\Database\Seeder;

class TestdataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * generate 50 author with "n" number of posts and "n" number of comments for each posts
         * "n" is corresponding to a random integer value between 1 and 10
         */

        Author::factory()
            ->count(50)
            //->hasPosts(rand(1,10))
            ->has(
                Post::factory()
                    ->count(rand(1,10))
                    ->hasComments(rand(1,10))
            )
            ->create();
    }
}
