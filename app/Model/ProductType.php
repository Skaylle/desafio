<?php

namespace App\Model;

class ProductType extends Model
{
    /**
     * @var string $table
     */
    protected string $table = 'product_types';

    /**
     * @var array $fillable
     */
    protected array $fillable = [
        'tax_id',
        'name',
        'description',
        'prefix',
    ];
}