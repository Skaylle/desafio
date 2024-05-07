<?php

namespace App\Request;

use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class ProductRequest
{
    public function validation(array $data): array
    {
        $object = json_decode(json_encode($data), false);

        $validator = v::attribute('product_type_id', v::notEmpty()->intType())
            ->attribute('name', v::notEmpty()->stringType()->length(1, 255))
            ->attribute('description', v::stringType()->length(0, 500))
            ->attribute('valor', v::notEmpty()->positive()->floatVal());

        try {
            $validator->assert($object);

           return ['status' => true];
        } catch (ValidationException $e) {
            $errors = [
                'product_type_id' => [
                    'notEmpty' => 'product_type_id must not be empty',
                    'intVal' => 'product_type_id must be an integer'
                ],
                'name' => [
                    'notEmpty' => 'name must not be empty',
                    'length' => 'name must have a length between 1 and 255'
                ],
                'description' => [
                    'length' => 'description must have a length between 1 and 500'
                ],
                'valor' => [
                    'notEmpty' => 'valor must not be empty',
                    'floatVal' => 'percent must be a valid decimal number with up to two decimal places and maximum total length of 10 characters'
                ]
            ];

            return [
                'status' => false,
                'errors' => $errors,
            ];
        }
    }
}