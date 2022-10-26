<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MovieRouteTest extends TestCase
{
    public function test_get_all_movies_route():void
    {
        $movies = Movie::factory(50)->create();
        
        $user = User::factory()->create();
      
        $token = Auth::login($user);

        $response = $this->getJson('api/movie', ['Authorization' => "Bearer $token"]);
        
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_get_movie_route():void
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->create();
        
        $token = Auth::login($user);

        $response = $this->getJson("api/movie/$movie->slug", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_store_movie_route():void
    {
        $movie = Movie::factory()->create()->toArray();
        $user = User::factory()->create();

        $token = Auth::login($user);
        
        $response = $this->postJson('api/movie', $movie, ['Authorization' => "Bearer $token"]);
        
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_update_movie_route():void
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->create();

        $token = Auth::login($user);
        
        $response = $this->putJson("api/movie/$movie->id", [
            'id' => $movie->id,
            'name' => 'Test Name', 
            'director_name' => 'Test Director', 
            'year' => '2001'
        ], ['Authorization' => "Bearer $token"]);
    

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_delete_movie_route():void
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->create();

        $token = Auth::login($user);
        
        $response = $this->deleteJson("api/movie/$movie->id", ['Authorization' => "Bearer $token"]);
    

        $response->assertStatus(Response::HTTP_OK);
    }
}
