<?php

namespace App\Controller;

use App\DB;

class IndexController
{
    public function index()
    {
        $message = "";

        try {
            DB::connect();
            $message = 'Database is connected.';
        }catch (\Exception $e){
            $message.= "ERROR: Can't connected to database. " . $e->getMessage();
        }
        return [
            "message" => "Welcome to your new controller! ",
            "path" => "app/Controller/IndexController.php",
            "connection" => $message,
        ];
    }
}
