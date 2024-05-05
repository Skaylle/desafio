<?php
namespace App;

use PDO;

class DB
{

    public static function connect(): PDO
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $user = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');
        $dbname = getenv('DB_DATABASE');
        $dbConnection = getenv('DB_CONNECTION');

        return new PDO("{$dbConnection}:host={$host};port={$port};dbname={$dbname}", $user, $password);
    }
}