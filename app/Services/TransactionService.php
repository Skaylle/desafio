<?php

namespace App\Services;

use App\DB;
use App\Model\Transaction;

class TransactionService extends Service
{
    /**
     * @var Transaction
     */
    protected Transaction $model;

    protected TransactionItemService $transactionItemService;

    public function __construct()
    {
        parent::__construct();
       $this->model = new Transaction(self::$pdo);
       //$this->transactionItemService = new TransactionItemService();
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
        try {
            $transaction = $this->model->create($data);
           // $this->transactionItem($data, $transaction['id']);

            $this->commit();
            return $transaction;
        }catch (\Exception $e){

        }
    }

    public function update($id, array $data)
    {
        return $this->model->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->model->destroy($id);
    }

    public function transactionItem($data, $id)
    {
        foreach ($data['transaction'] as $transaction) {
            if($transaction['transaction_item_id']) {
                $this->transactionItemService->update($transaction['transaction_item_id'], $transaction);
            }else{
                $transaction['transaction_id'] = $id;
                $this->transactionItemService->create($transaction);
            }
        }
    }
}