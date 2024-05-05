<?php

namespace App\Services;

use App\DB;
use App\Model\Transaction;

class TransactionService
{
    /**
     * @var Transaction
     */
    protected Transaction $model;

    protected TransactionItemService $transactionItemService;

    public function __construct()
    {
       $db = DB::connect();
       $this->model = new Transaction($db);
       $this->transactionItemService = new TransactionItemService($db);
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
        $this->model->beginTransaction();
        try {
            $transaction = $this->model->create($data);
            $this->transactionItem($data, $transaction['id']);

            $this->model->commit();
            return $transaction;
        }catch (\Exception $e){
            $this->model->rollback();
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