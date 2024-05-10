<?php

namespace App\Services;

use App\DB;
use App\Model\Transaction;
use PDO;

class TransactionService
{
    /**
     * @var Transaction
     */
    protected Transaction $model;

    protected TransactionItemService $transactionItemService;

    public function __construct()
    {
        $this->model = new Transaction();
        $this->transactionItemService = new TransactionItemService();
    }

    public function index()
    {
        $db = DB::connect();
        $stmt = $db->query("SELECT *, to_char(created_at, 'DD/MM/YYYY') as create_fmt FROM transactions order by id desc");
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($transactions as $key => $transaction) {
            $db = DB::connect();
            $stmt = $db->query("SELECT *,  products.name as product_label
                                       FROM transaction_items
                                       JOIN products ON products.id = transaction_items.product_id
                                       ");
            $transactions[$key]['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $transactions;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        try {
            $transaction = $this->model->create($data);
            $this->transactionItem($data, $transaction['id']);

            return $transaction;
        } catch (\Exception $e) {

        }
    }

    public function update($id, array $data)
    {
        return $this->model->update($id, $data);
    }

    public function delete($id): bool
    {
        try {
            $this->deleteItem($id);

            return $this->model->destroy($id);
        }catch (\Exception $exception){
            return false;
        }
    }

    public function transactionItem($data, $id)
    {
        foreach ($data['transaction'] as $transaction) {
            if ($transaction['transaction_item_id']) {
                $this->transactionItemService->update($transaction['transaction_item_id'], $transaction);
            } else {
                $transaction['transaction_id'] = $id;
                $this->transactionItemService->create($transaction);
            }
        }
    }

    public function deleteItem($id)
    {
        $db = DB::connect();
        $stmt = $db->query("SELECT id FROM transaction_items where transaction_id = ?", [$id]);
        $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($item as $value) {
            $this->transactionItemService->delete($value['id']);
        }
    }
}