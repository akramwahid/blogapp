<?php

namespace Tests\Feature;

use App\Models\Blog\Comment;
use App\Models\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{

    /**
     * test add new comment feature
     * api method: PostCommentController@store
     *
     * @return void
     */
    public function test_comments_create()
    {
        //generate a post model persisting in db
        $post = Post::factory()->create();

        $payload = Comment::factory()->make([
            'post_id' => $post->id
        ]);

        $this->json('POST', '/api/posts/'.$post->id.'/comments', $payload->toArray())
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'message' => $payload->message,
                    'post_id' => $post->id
                ]
            ]);
    }

    /**
     * test delete comment feature
     * api method: PostCommentController@destroy
     * @return void
     */
    public function test_comments_delete()
    {
        //generate an author model persisting in db
        $comment = Comment::factory()->create();

        $this->json('DELETE', '/api/comments/'.$comment->id)
            ->assertStatus(204);

    }

    /**
     * test comment list feature
     * api method: PostCommentController@index
     * @return void
     */
    public function test_comments_list()
    {
        //generate a post model persisting in db
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'post_id' => $post->id
        ]);

        $this->json('GET', '/api/posts/'.$post->id.'/comments')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $comment->id,
                        'message' => $comment->message,
                        'post_id' => $post->id
                    ]
                ]
            ]);

    }
}
