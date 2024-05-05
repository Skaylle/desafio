<?php

namespace App\Controller;

use App\Services\ProductTypesService;

class ProductTypeController
{
    protected ProductTypesService $product;

    public function __construct()
    {
        $this->product = new ProductTypesService();
    }

    public function index()
    {
        return $this->product->index();
    }

    public function show(int $id)
    {
        return $this->product->find($id);
    }

    public function store(array $params)
    {
        return $this->product->create($params);
    }

    public function update(int $id, array $params)
    {
        return $this->product->update($id, $params);
    }

    public function delete(int $id): bool
    {
        return $this->product->delete($id);
    }
}