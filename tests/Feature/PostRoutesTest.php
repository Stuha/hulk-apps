<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PostRoutesTest extends TestCase
{
    public function test_get_post_route():void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id, 'movie_id' => $movie->id]);

        $token = Auth::login($user);

        $response = $this->getJson("api/post/$post->id", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_store_post_route():void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        
        $post = Post::factory()->create(['user_id' => $user->id, 'movie_id' => $movie->id])->toArray();
    
        $token = Auth::login($user);
       
        $response = $this->postJson('api/post', $post, ['Authorization' => "Bearer $token"]);
        
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_update_post_route():void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id, 'movie_id' => $movie->id]);
    
        $token = Auth::login($user);
        
        $response = $this->putJson("api/post/$post->id", [
            'id' => $post->id,
            'content' => 'Test Content',
            'user_id' => $post->user_id,
            'movie_id' =>$post->movie_id 
        ], ['Authorization' => "Bearer $token"]);
    
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_delete_post_route():void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id, 'movie_id' => $movie->id]);
        
        $token = Auth::login($user);
        
        $response = $this->deleteJson("api/post/$post->id", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
