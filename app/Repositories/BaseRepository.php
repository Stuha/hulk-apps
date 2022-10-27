<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements BaseRepositoryInterface 
{

    protected Model $model;

    public function __construct(Model $model)
    {
           $this->model = $model;
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function fetchAll():Collection|LengthAwarePaginator
    {
        return $this->model->all();
    }

    public function update($params, $id):Model
    {
        $model = $this->model->where('id', $id)->first();
        $model->update($params);

        return $model;
    }

    public function delete($id):void
    {
        $this->model->where('id', $id)->first()->delete();
    }

    public function findById($id):Model
    {
        return $this->model->where('id', $id)->first();
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}