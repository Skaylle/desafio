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
                                       WHERE transaction_id = {$transaction['id']} 
                                       ");
            $transactions[$key]['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $transactions;
    }

    public function find($id)
    {
        $db = DB::connect();
        $stmt = $db->query("SELECT *, to_char(created_at, 'DD/MM/YYYY') as create_fmt FROM transactions where id = {$id}");
        $transactions = $stmt->fetch(PDO::FETCH_ASSOC);

        $itemsStmt = $db->query("SELECT *,  products.name as product_label
                               FROM transaction_items
                               JOIN products ON products.id = transaction_items.product_id
                               WHERE transaction_id = {$id}
                               ");
        $transactions['items'] = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

        return $transactions;
    }

    public function create(array $data)
    {
        $data = $this->dataFormatter($data);

        try {
            $transaction = $this->model->create($data);
            $this->transactionItem($data, $transaction['id']);

            return $transaction;
        } catch (\Exception $e) {

        }
    }

    public function update($id, array $data)
    {
        $data = $this->dataFormatter($data);
        try {
            $transaction = $this->model->update($id, $data);
            $this->transactionItem($data, $transaction['id']);
            return $transaction;
        } catch (\Exception $e) {

        }
    }

    public function delete($id): bool
    {
        try {
            $this->deleteItem($id);

            return $this->model->destroy($id);
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function transactionItem($data, $id)
    {
        $existingItems = $this->transactionItemService->findByTransactionId($id);

        $existingItemIds = [];

        foreach ($data['transaction'] as $transaction) {
            $exists = $this->transactionItemService->find($transaction['id']);

            if ($exists) {
                $this->transactionItemService->update($exists['id'], $transaction);
                $existingItemIds[] = $transaction['id'];
            } else {
                $transaction['transaction_id'] = $id;
                $save = $this->transactionItemService->create($transaction);
                $existingItemIds[] = $save['id'];
            }
        }

        foreach ($existingItems as $existingItem) {
            if (!in_array($existingItem['id'], $existingItemIds)) {
                $this->transactionItemService->delete($existingItem['id']);
            }
        }
    }

    public function deleteItem($id)
    {
        $db = DB::connect();
        $stmt = $db->query("SELECT id FROM transaction_items where transaction_id = {$id}");
        $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($item as $value) {
            $this->transactionItemService->delete($value['id']);
        }
    }

    private function dataFormatter(array $arrData): array
    {
          foreach ($arrData['transaction'] as $key => $data) {
              $data['total'] = $this->convertCurrencyToNumeric($data['total']);
              $data['subtotal'] = $this->convertCurrencyToNumeric($data['subtotal']);

              $arrData['transaction'][$key] = $data;
        }


        return $arrData;
    }

    private function convertCurrencyToNumeric($value): float
    {
        $numeric_value = str_replace(array('R$', '.'), '', $value);
        $numeric_value = str_replace(',', '.', $numeric_value);
        $numeric_value = floatval($numeric_value);
        return round($numeric_value, 2);
    }
}