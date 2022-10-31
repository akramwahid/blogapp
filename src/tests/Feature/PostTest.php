<?php

namespace Tests\Feature;

use App\Models\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * test create new post feature
     * api method: PostController@store
     *
     * @return void
     */
    public function test_posts_create()
    {
        //generate a post model without persisting in db
        $payload = Post::factory()->make();

        $this->json('POST', '/api/posts', $payload->toArray())
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => $payload->title,
                    'body' => $payload->body,
                    'image' => $payload->image,
                    'author' => [
                        'id' => $payload->author_id
                    ]
                ]
            ]);
    }


    /**
     * test update post feature
     * api method: PostController@update
     * @return void
     */
    public function test_posts_update()
    {
        //generate a post model persisting in db
        $post = Post::factory()->create();

        //generate a post model without persisting in db
        $payload = Post::factory()->make();

        $this->json('PUT', '/api/posts/'.$post->id, $payload->toArray())
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $post->id,
                    'title' => $payload->title,
                    'body' => $payload->body,
                    'image' => $payload->image,
                    'author' => [
                        'id' => $payload->author_id
                    ]
                ]
            ]);

    }

    /**
     * test delete post feature
     * api method: PostController@destroy
     * @return void
     */
    public function test_posts_delete()
    {
        //generate a post model persisting in db
        $post = Post::factory()->create();

        $this->json('DELETE', '/api/posts/'.$post->id)
            ->assertStatus(204);

    }

    /**
     * test post list feature
     * api method: PostController@index
     * @return void
     */
    public function test_posts_list()
    {
        $first_post = Post::factory()->create();
        $second_post = Post::factory()->create();

        $this->json('GET', '/api/posts')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $first_post->id,
                        'title' => $first_post->title,
                        'body' => $first_post->body,
                        'image' => $first_post->image,
                        'author' => [
                            'id' => $first_post->author_id
                        ]
                    ],
                    [
                        'id' => $second_post->id,
                        'title' => $second_post->title,
                        'body' => $second_post->body,
                        'image' => $second_post->image,
                        'author' => [
                            'id' => $second_post->author_id
                        ]
                    ]
                ]
            ]);

    }

    /**
     * test post list search by author feature, create 2 posts with same author, and 20 posts with random authors
     * search by the author of two posts, and search result must be 2
     * api method: PostController@index
     * @return void
     */
    public function test_posts_list_search()
    {
        //create a random post with author
        $first_post = Post::factory()->create();

        //create a second post for same author
        $second_post = Post::factory()->create([
            'title' => 'lorum',
            'author_id' => $first_post->author->id
        ]);

        //create 20 additional random post with random authors
        Post::factory()->count(20)->create();

        //the search result should be 2 even though there will be 22 posts in db
        $this->json('GET', '/api/posts', ['searchAuthor' => $first_post->author->name])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $first_post->id,
                        'title' => $first_post->title,
                        'body' => $first_post->body,
                        'image' => $first_post->image,
                        'author' => [
                            'id' => $first_post->author_id
                        ]
                    ],
                    [
                        'id' => $second_post->id,
                        'title' => 'lorum',
                        'body' => $second_post->body,
                        'image' => $second_post->image,
                        'author' => [
                            'id' => $first_post->author_id
                        ]
                    ]
                ]
            ])
            ->assertJsonCount(2, "data");

    }


}
