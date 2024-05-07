<?php

namespace App\Services;

use App\DB;
use App\Model\ProductType;
use PDO;

class ProductTypesService
{
    /**
     * @var ProductType
     */
    protected ProductType $model;

    public function __construct()
    {
       $this->model = new ProductType();
    }

    public function index()
    {
        $db = DB::connect();
        $stmt = $db->query("SELECT pt.*, t.name as tax_label, t.percent
                                   FROM product_types pt
                                   JOIN taxes t ON t.id = pt.tax_id                 
                                   ORDER BY pt.id DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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