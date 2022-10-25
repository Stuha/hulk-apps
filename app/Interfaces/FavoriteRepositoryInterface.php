<?php

namespace App\Interfaces;

use App\Models\Movie;
use App\Models\User;
use Maize\Markable\Models\Favorite;
use Illuminate\Pagination\LengthAwarePaginator;

interface FavoriteRepositoryInterface
{
    public function getAllFavorites():LengthAwarePaginator;
    public function deleteFavorite(Movie $movie, User $user):void;
    public function createFavorite(Movie $movie, User $user):Favorite;
}