<?php

namespace App\Model;

class TransactionItem extends Model
{
    /**
     * @var string $table
     */
    protected string $table = 'transaction_items';

    protected array $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'subtotal',
        'total'
    ];
}