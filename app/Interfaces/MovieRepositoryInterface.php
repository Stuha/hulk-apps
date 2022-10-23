<?php

namespace App\Interfaces;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

interface MovieRepositoryInterface
{
    public function getAllMovies():Collection;
    public function getMovieById(int $movieId):Movie;
}