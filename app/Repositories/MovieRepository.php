<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\BaseRepository;

use Illuminate\Pagination\LengthAwarePaginator;

class MovieRepository extends BaseRepository
{
    public function __construct(Movie $model){
        parent::__construct($model);
    }

    public function fetchAll():LengthAwarePaginator
    {
        return Movie::filter()->paginate(25);
    }
}
