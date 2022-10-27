<?php

namespace Tests\Feature;

use App\Models\Followable;
use App\Models\Movie;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FollowRoutesTest extends TestCase
{
    public function test_get_all_follows_route():void
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->create();

        Followable::factory()->create([
            'user_id' => $user->id, 
            'followable_id' => $movie->id, 
            'followable_type' => Movie::class,
            'followed_at' => Carbon::now()
        ]);
      
        $token = Auth::login($user);

        $response = $this->getJson('api/follow', ['Authorization' => "Bearer $token"]);
        
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_store_follow_route():void
    {
        $movie = Movie::factory()->create()->toArray();
        $user = User::factory()->create();

        $token = Auth::login($user);
        
        $response = $this->postJson('api/follow', $movie, ['Authorization' => "Bearer $token"]);
        
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_delete_follow_route():void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $followable = Followable::factory()->create([
            'user_id' => $user->id, 
            'followable_id' => $movie->id, 
            'followable_type' => Movie::class,
            'followed_at' => Carbon::now()
        ]);
        
        $token = Auth::login($user);
        
        $response = $this->deleteJson("api/follow/$followable->id", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(Response::HTTP_OK);
    }

}
