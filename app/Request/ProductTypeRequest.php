<?php

namespace App\Request;

use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class ProductTypeRequest
{
    public function validation(array $data): array
    {
        $object = json_decode(json_encode($data), false);

        $validator = v::attribute('tax_id', v::notEmpty()->intType())
            ->attribute('name', v::notEmpty()->stringType()->length(1, 255))
            ->attribute('description', v::stringType()->length(1, 500))
            ->attribute('prefix', v::notEmpty()->stringType()->length(1, 10));
        ;

        try {
            $validator->assert($object);
           return ['status' => true];
        } catch (ValidationException $e) {
            $errors = [
                'tax_id' => [
                    'notEmpty' => 'tax_id must not be empty',
                    'intVal' => 'tax_id must be an integer'
                ],
                'name' => [
                    'notEmpty' => 'name must not be empty',
                    'length' => 'name must have a length between 1 and 255'
                ],
                'description' => [
                    'length' => 'description must have a length between 1 and 500'
                ],
                'prefix' => [
                    'notEmpty' => 'prefix must not be empty',
                    'length' => 'prefix must have a length between 1 and 10'
                ],
            ];

            return [
                'status' => false,
                'errors' => $errors,
            ];
        }
    }
}