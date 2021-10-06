<?php

namespace App\Repositories\Base;
use App\Repositories\Base\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    public function where($column, $value)
    {
        return $this->model->where($column, $value);
    }

}
