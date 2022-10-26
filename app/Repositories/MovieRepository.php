<?php

namespace App\Repositories;

use App\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use App\Repositories\BaseRepository;

use Illuminate\Database\Eloquent\Collection;
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

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}
