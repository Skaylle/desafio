<?php

namespace App\Services;

use App\DB;
use App\Model\ProductType;

class ProductTypesService
{
    /**
     * @var ProductType
     */
    protected ProductType $model;

    public function __construct()
    {
       $this->model = new ProductType(DB::connect());
    }

    public function index()
    {
        return  $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->model->destroy($id);
    }
}