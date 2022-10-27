<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FavoriteRoutesTest extends TestCase
{
    public function test_get_all_favorites_route():void
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->create();

        Favorite::factory()->create([
            'user_id' => $user->id, 
            'markable_id' => $movie->id, 
            'markable_type' => Movie::class,
        ]);
      
        $token = Auth::login($user);

        $response = $this->getJson('api/favorite', ['Authorization' => "Bearer $token"]);
        
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_store_favorite_route():void
    {
        $movie = Movie::factory()->create()->toArray();
        $user = User::factory()->create();

        $token = Auth::login($user);
        
        $response = $this->postJson('api/follow', $movie, ['Authorization' => "Bearer $token"]);
        
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_delete_favorite_route():void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $favorite = Favorite::factory()->create([
            'user_id' => $user->id, 
            'markable_id' => $movie->id, 
            'markable_type' => Movie::class,
        ]);
        
        $token = Auth::login($user);
        
        $response = $this->deleteJson("api/favorite/$favorite->id", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
