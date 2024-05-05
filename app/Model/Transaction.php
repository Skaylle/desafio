<?php

namespace App\Model;

class Transaction extends Model
{
    /**
     * @var string $table
     */
    protected string $table = 'transactions';

    /**
     * @var array $fillable
     */
    protected array $fillable = [
        'total',
        'total_tax',
    ];
}