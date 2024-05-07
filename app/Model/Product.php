<?php

namespace App\Model;

class Product extends Model
{
    /**
     * @var string $table
     */
    protected string $table = 'products';

    /**
     * @var array $fillable
     */
    protected array $fillable = [
        'product_type_id',
        'code',
        'name',
        'valor',
        'description'
    ];
}