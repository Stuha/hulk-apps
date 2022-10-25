<?php

namespace App\Repositories;

use App\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieRepository implements MovieRepositoryInterface
{
    public function getAllMovies():LengthAwarePaginator
    {
        return Movie::paginate(25);
    }

    public function getMovieById(int $id):Movie
    {
        return Movie::findOrFail($id);
    }
}
