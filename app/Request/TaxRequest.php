<?php

namespace App\Request;

use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class TaxRequest
{
    public function validation(array $data): array
    {
        $object = json_decode(json_encode($data), false);

        $validator = v::attribute('percent', v::notEmpty()->positive()->floatVal())
            ->attribute('name', v::notEmpty()->stringType()->length(1, 255))
            ->attribute('description', v::stringType()->length(1, 500));

        try {
            $validator->assert($object);
            return ['status' => true];
        } catch (ValidationException $e) {
            $errors = [
                'percent' => [
                    'notEmpty' => 'percent must not be empty',
                    'floatVal' => 'percent must be a valid decimal number with up to two decimal places and maximum total length of 10 characters'
                ],
                'name' => [
                    'notEmpty' => 'name must not be empty',
                    'length' => 'name must have a length between 1 and 255'
                ],
                'description' => [
                    'length' => 'description must have a length between 1 and 500'
                ],
            ];

            return [
                'status' => false,
                'errors' => $errors,
            ];
        }
    }
}