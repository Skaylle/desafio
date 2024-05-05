<?php

namespace App\Controller;

use App\Request\ProductRequest;
use App\Services\ProductService;
use Exception;
use http\Client\Response;
use HttpResponseException;

class ProductController
{
    protected ProductService $product;

    protected ProductRequest $productRequest;

    public function __construct()
    {
        $this->product = new ProductService();
        $this->productRequest = new ProductRequest();
    }

    public function index()
    {
        return $this->product->index();
    }

    public function show(int $id)
    {
        return $this->product->find($id);
    }

    public function store(array $params): ?array
    {
        return $this->product->create($params);;
    }

    public function update(int $id, array $params)
    {
        return $this->product->update($id, $params);
    }

    public function delete(int $id): bool
    {
        return $this->product->delete($id);
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