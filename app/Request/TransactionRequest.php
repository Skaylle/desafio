<?php

namespace App\Request;

use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class TransactionRequest
{
    public function validation(array $data): array
    {
        $object = json_decode(json_encode($data), false);

        $validator = v::attribute('total', v::notEmpty()->positive()->floatVal())
            ->attribute('total_tax', v::notEmpty()->positive()->floatVal())
            ->attribute('total_product', v::notEmpty()->positive()->floatVal());

        try {
            $validator->assert($object);
           return ['status' => true];
        } catch (ValidationException $e) {
            $errors = [
                'total' => [
                    'notEmpty' => 'total must not be empty',
                    'floatVal' => 'total must be a valid decimal number',
                    'positive' => 'total must be a positive number'
                ],
                'total_tax' => [
                    'notEmpty' => 'total_tax must not be empty',
                    'floatVal' => 'total_tax must be a valid decimal number',
                    'positive' => 'total_tax must be a positive number'
                ],
                'total_product' => [
                    'notEmpty' => 'total_product must not be empty',
                    'floatVal' => 'total_product must be a valid decimal number',
                    'positive' => 'total_product must be a positive number'
                ]
            ];

            return [
                'status' => false,
                'errors' => $errors,
            ];
        }
    }
}