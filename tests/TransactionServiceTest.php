<?php
require_once 'AbstractTest.php';

use App\Services\TransactionService;

class TransactionServiceTest extends AbstractTest
{
    protected TransactionService $service;

    protected array $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TransactionService();
        $this->data = $this->testAbstractCreateTransaction();
    }

    /**
     * @covers App\Services\TransactionService::index
     */
    public function testIndex()
    {
        $this->testAbstractCrateTax();
        $result = $this->service->index();
        $this->assertIsArray($result);
    }

    /**
     * @covers App\Services\TransactionService::create
     */
    public function testCreate()
    {
        $this->assertIsArray($this->data);
    }

    /**
     * @covers App\Services\TransactionService::find
     */
    public function testFind()
    {
        $result = $this->service->find($this->data['id']);
        $this->assertNotNull($result);
    }

    /**
     * @covers App\Services\TransactionService::update
     */
    public function testUpdate()
    {
        $transaction = $this->service->find($this->data['id']);
        $this->assertIsArray($transaction);
        $item = $transaction['items'];
        $this->assertIsArray($item);
        unset($transaction['items']);

        $arrTransaction = [
            'transaction' => [
                array_merge($item[0], [
                    'quantity' => 5,
                    'subtotal' => 9,
                    'total' => 9,
                ])
            ]
        ];

        $result = $this->service->update($this->data['id'], array_merge($transaction, $arrTransaction));
        $this->assertIsArray($result);
    }

    /**
     * @covers App\Services\TransactionService::delete
     */
    public function testDelete()
    {
        $result = $this->service->delete($this->data['id']);
        $this->assertIsBool($result);
    }
}
