<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Movie;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Movie::factory(50)->create()->each(function ($movie) {
            $user = User::factory()->create();

            Post::factory(10)->create([
                'user_id' => $user->id, 
                'movie_id' => $movie['id']
            ]);
        });
    }
}
