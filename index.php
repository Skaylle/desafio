<?php

use App\DB;
use App\Router;

require __DIR__ . '/vendor/autoload.php';
require 'router.php';
require 'DB.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

date_default_timezone_set('America/Sao_Paulo');
set_exception_handler('handleException');

$envFilePath = __DIR__ . '/.env';
if (file_exists($envFilePath)) {
    $envVariables = parse_ini_file($envFilePath);
    foreach ($envVariables as $key => $value) {
        putenv("$key=$value");
    }
}

function handleException($exception) {
    $db = DB::connect();
    $db->rollBack();

    // Registre a exceção em um arquivo de log
    error_log('Erro não tratado: ' . $exception->getMessage());

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $exception->getMessage(),
        'code' => $exception->getCode(),
        'path' => $exception->getFile(),
    ]);
    exit;
}

$response = Router::route();
echo json_encode($response);