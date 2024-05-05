<?php

namespace App\Controller;

use App\Services\TransactionService;

class TransactionController
{
    protected TransactionService $service;

    public function __construct()
    {
        $this->service = new TransactionService();
    }

    public function index()
    {
        return $this->service->index();
    }

    public function show(int $id)
    {
        return $this->service->find($id);
    }

    public function store(array $params)
    {
        return $this->service->create($params);
    }

    public function update(int $id, array $params)
    {
        return $this->service->update($id, $params);
    }

    public function delete(int $id): bool
    {
        return $this->service->delete($id);
    }
}