<?php

namespace App\Request;

use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class ProductRequest
{
    public function validation(array $data): array
    {
        $object = json_decode(json_encode($data), false);

        $userValidator = v::attribute('product_type_id', v::notEmpty()->intType())
            ->attribute('name', v::notEmpty()->stringType()->length(1, 255))
            ->attribute('description', v::notEmpty()->stringType()->length(1, 500))
            ->attribute('valor', v::notEmpty());

        try {
            $userValidator->assert($object);
           return ['status' => true];
        } catch (ValidationException $e) {
            $errors = [
                'product_type_id' => [
                    'notEmpty' => 'product_type_id must not be empty',
                    'intType' => 'product_type_id must be of type integer'
                ],
                'name' => [
                    'notEmpty' => 'name must not be empty',
                    'length' => 'name must have a length between 1 and 255'
                ],
                'description' => [
                    'notEmpty' => 'description must not be empty'
                ],
                'valor' => [
                    'notEmpty' => 'valor must not be empty'
                ]
            ];

            return [
                'status' => false,
                'errors' => $errors,
            ];
        }
    }
}