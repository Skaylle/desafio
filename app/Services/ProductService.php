<?php

namespace App\Services;

use App\DB;
use App\Model\Product;
use PDO;

class ProductService
{
    /**
     * @var Product
     */
    protected Product $model;

    public function __construct()
    {
        $this->model = new Product();
    }

    public function index()
    {
        $db = DB::connect();
        $stmt = $db->query("SELECT p.*, pt.name as product_type_label, p.product_type_id
                                   FROM products p
                                   JOIN product_types pt ON pt.id = p.product_type_id             
                                   ORDER BY p.id DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        $number = str_pad("$count", 6, '0', STR_PAD_LEFT);

        return "{$productType['prefix']}{$number}";
    }
}