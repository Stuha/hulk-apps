<?php

namespace App\Repositories;

use App\Interfaces\FavoriteRepositoryInterface;
use Maize\Markable\Models\Favorite;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Movie;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class FavoriteRepository implements FavoriteRepositoryInterface
{
    public function getAllFavorites():Collection
    {
        return Movie::whereHasFavorite(
            auth()->user(),
        )->get();
    }

    public function createFavorite(Movie $movie, User $user):Favorite
    {
        return Favorite::add($movie, $user);
    }

    public function deleteFavorite(Movie $movie, User $user):void
    {
        Favorite::remove($movie, $user);
    }
}