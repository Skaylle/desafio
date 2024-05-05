<?php

namespace App\Services;

use App\DB;
use App\Model\Product;
use App\Model\ProductType;
use http\Exception\BadQueryStringException;

class ProductService
{
    /**
     * @var Product
     */
    protected Product $model;

    public function __construct()
    {
       $this->model = new Product(DB::connect());
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
            return $this->model->create(array_merge($data, [
                'code' => $this->generateCodeProduct($data['product_type_id'])]));
    }

    public function update($id, array $data)
    {
        return $this->model->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->model->destroy($id);
    }

    private function generateCodeProduct($productTypeId): string
    {
        $productType = (new \App\Model\ProductType)->find($productTypeId);

        $count = $this->model->count();
        $count++;

        return str_pad("{$productType['prefix']}$count", 10, '0', STR_PAD_RIGHT);
    }
}