<?php

require_once 'DB.php';

use App\DB;
use App\Services\ProductService;
use App\Services\ProductTypesService;
use App\Services\TaxService;
use App\Services\TransactionService;
use PHPUnit\Framework\TestCase;

class AbstractTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->database = DB::connect();
        $this->database->beginTransaction();
    }

    /**
     * @covers App\Services\TaxService::create
     */
    public function testAbstractCrateTax($arrData = [])
    {
        $data = [
            'name' => 'Imposto Teste',
            'percent' => 0.10,
            'description' => 'TESTE UNITARIO'
        ];

        $taxService = new TaxService();
        $result = $taxService->create(array_merge($arrData, $data));
        $this->assertIsArray($result);
        return $result;
    }

    /**
     * @covers App\Services\ProductTypesService::create
     */
    public function testAbstractCraProductType($arrData = [])
    {
        $tax = $this->testAbstractCrateTax();

        $data = [
            'tax_id' => $tax['id'],
            'name' => 'TIPO PRODUTO TESTE v1',
            'prefix' => 'PMP',
            'description' => 'TESTE UNITARIO - TIPO PRODUTO'
        ];

        $service = new ProductTypesService();
        $result = $service->create(array_merge($arrData, $data));
        $this->assertIsArray($result);
        return $result;
    }

    /**
     * @covers App\Services\ProductService::create
     */
    public function testAbstractCreateProduct($arrData = [])
    {
        $type = $this->testAbstractCraProductType();

        $data = [
            'product_type_id' => $type['id'],
            'name' => 'PRODUTO TESTE v1',
            'valor' => 11.00,
            'description' => 'TESTE UNITARIO - PRODUTO'
        ];

        $service = new ProductService();
        $result = $service->create(array_merge($arrData, $data));
        $this->assertIsArray($result);
        return $result;
    }

    /**
     * @covers App\Services\TransactionService::create
     */
    public function testAbstractCreateTransaction($arrData = [])
    {
        $product = $this->testAbstractCreateProduct();
        $arrTransaction = [
            'total' => 2000,
            'total_tax' => 50,
            'transaction' => [
                [
                    'id' => '',
                    'transaction_id' => '',
                    'product_id' => $product['id'],
                    'quantity' => 2,
                    'subtotal' => 40000,
                    'total' => 500,
                ]
            ]
        ];

        $service = new TransactionService();
        $result = $service->create(array_merge($arrData, $arrTransaction));
        $this->assertIsArray($result);
        return $result;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->database->rollback();
    }
}