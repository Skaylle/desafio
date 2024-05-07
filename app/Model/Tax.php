<?php

namespace App\Model;

class Tax extends Model
{
    /**
     * @var string $table
     */
    protected string $table = 'taxes';

    /**
     * @var array $fillable
     */
    protected array $fillable = [
        'percent',
        'name',
        'description',
    ];
}