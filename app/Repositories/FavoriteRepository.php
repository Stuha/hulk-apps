<?php

namespace App\Repositories;

use App\Interfaces\FavoriteRepositoryInterface;
use Maize\Markable\Models\Favorite;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Movie;
use Illuminate\Foundation\Auth\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class FavoriteRepository implements FavoriteRepositoryInterface
{
    public function getAllFavorites():LengthAwarePaginator
    {
        return Movie::whereHasFavorite(
            Auth::user(),
        )->paginate(25);
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