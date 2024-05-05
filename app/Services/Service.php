<?php

namespace App\Services;

use App\DB;

class Service
{
    protected static \PDO $pdo;

    public function __construct()
    {
        self::$pdo = DB::connect();
        self::$pdo->beginTransaction();
    }

    public function commit()
    {
        self::$pdo->commit();
    }

    public function rollback()
    {
        self::$pdo->rollback();
    }
}