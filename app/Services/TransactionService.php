<?php

namespace App\Services;

use App\Model\Product;
use App\Model\ProductType;
use App\Model\Tax;
use App\Model\Transaction;

class TransactionService
{
    /**
     * @var Transaction
     */
    protected Transaction $model;

    public function __construct()
    {
       $this->model = new Transaction();
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
        $this->ProductCalculator($data);
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

    public function ProductCalculator($data)
    {
        $product = (new \App\Model\Product)->find($data['product_id']);
        $type = (new \App\Model\ProductType)->find($product['product_type_id']);
        $tax = (new \App\Model\Tax)->find($type['tax_id']);
        $quantidade = 2;

        $vrTotalProduto = $product['valor'] * $quantidade;
        $valorTax = $product['valor'] * ($tax['percent'] / 100);


        var_dump('Produto', $product['valor'] , ' ');
        var_dump('Imposto', $tax['percent'] , ' ');
        var_dump('Total Produto', $vrTotalProduto, ' ');
        var_dump('Total Imposto', $valorTax, ' ');
        var_dump('Toal Venda', $vrTotalProduto + $valorTax, ' ');


       die;
    }
}