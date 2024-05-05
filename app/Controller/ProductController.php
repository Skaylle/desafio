<?php

namespace App\Controller;

use App\Request\ProductRequest;
use App\Services\ProductService;

class ProductController
{
    protected ProductService $service;

    protected ProductRequest $productRequest;

    public function __construct()
    {
        $this->service = new ProductService();
        $this->productRequest = new ProductRequest();
    }

    public function index()
    {
        return $this->service->index();
    }

    public function show(int $id)
    {
        return $this->service->find($id);
    }

    public function store(array $params): ?array
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

    public function validate(array $params): array
    {
        $validate = $this->productRequest->validation($params);
        if(!$validate['status']) {
            http_response_code(400);
            return [
                'data' => ['error' => $validate['errors']],
                'success' => false,
                'message' => 'Erro ao validar a dados, verifique todos os campos e tente novamente',
            ];
        }

        return ['success' => true];
    }
}