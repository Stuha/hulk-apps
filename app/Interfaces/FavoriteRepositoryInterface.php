<?php

namespace App\Interfaces;

use App\Models\Movie;
use App\Models\User;
use Maize\Markable\Models\Favorite;
use Illuminate\Database\Eloquent\Collection;

interface FavoriteRepositoryInterface
{
    public function getAllFavorites():Collection;
    public function deleteFavorite(Movie $movie, User $user):void;
    public function createFavorite(Movie $movie, User $user):Favorite;
}