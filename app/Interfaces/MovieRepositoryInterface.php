<?php

namespace App\Interfaces;

use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;

interface MovieRepositoryInterface
{
    public function getAllMovies():LengthAwarePaginator;
    public function getMovieById(int $movieId):Movie;
}