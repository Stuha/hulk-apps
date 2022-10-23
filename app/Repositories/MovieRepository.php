<?php

namespace App\Repositories;

use App\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

class MovieRepository implements MovieRepositoryInterface
{
    public function getAllMovies():Collection
    {
        return Movie::all();
    }

    public function getMovieById(int $id):Movie
    {
        return Movie::findOrFail($id);
    }
}
