<?php

namespace App\Services;

use App\Model\TransactionItem;

class TransactionItemService
{
    /**
     * @var TransactionItem
     */
    protected TransactionItem $model;

    public function __construct()
    {
       $this->model = new TransactionItem();
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