<?php

namespace Zoe;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class EloquentRepository
{
    protected $model = null;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

}