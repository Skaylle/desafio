<?php
require_once 'AbstractTest.php';

use App\Services\ProductService;
class ProductServiceTest extends AbstractTest
{
    protected ProductService $service;

    protected array $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ProductService();
        $this->data =  $this->testAbstractCreateProduct();
    }

    /**
     * @covers App\Services\ProductService::index
     */
    public function testIndex()
    {
        $this->testAbstractCreateProduct();
        $result = $this->service->index();
        $this->assertIsArray($result);
    }

    /**
     * @covers App\Services\ProductService::create
     */
    public function testCreate()
    {
        $this->assertIsArray($this->data);
    }

    /**
     * @covers App\Services\ProductService::find
     */
    public function testFind()
    {
        $result = $this->service->find($this->data['id']);
        $this->assertNotNull($result);
    }

    /**
     * @covers App\Services\ProductService::update
     */
    public function testUpdate()
    {
        $result = $this->service->update($this->data['id'],
            ['name' => 'PRODUTO TESTE v2', 'description' => 'TESTE UNITARIO - PRODUTO - TESTE UPDATE']);
        $this->assertIsArray($result);
    }

    /**
     * @covers App\Services\ProductService::delete
     */
    public function testDelete()
    {
        $result = $this->service->delete($this->data['id']);
        $this->assertIsBool($result);
    }
}
