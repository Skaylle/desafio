<?php
require_once 'AbstractTest.php';

use App\Services\ProductTypesService;
class ProductTypeServiceTest extends AbstractTest
{
    protected ProductTypesService $service;

    protected array $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ProductTypesService();
        $this->data =  $this->testAbstractCraProductType();
    }

    /**
     * @covers App\Services\ProductTypesService::index
     */
    public function testIndex()
    {
        $this->testAbstractCraProductType();
        $result = $this->service->index();
        $this->assertIsArray($result);
    }

    /**
     * @covers App\Services\ProductTypesService::create
     */
    public function testCreate()
    {
        $this->assertIsArray($this->data);
    }

    /**
     * @covers App\Services\ProductTypesService::find
     */
    public function testFind()
    {
        $result = $this->service->find($this->data['id']);
        $this->assertNotNull($result);
    }

    /**
     * @covers App\Services\ProductTypesService::update
     */
    public function testUpdate()
    {
        $result = $this->service->update($this->data['id'],
            ['name' => 'TIPO PRODUTO TESTE v2', 'description' => 'TESTE UNITARIO - TIPO PRODUTOTESTE UPDATE']);
        $this->assertIsArray($result);
    }

    /**
     * @covers App\Services\ProductTypesService::delete
     */
    public function testDelete()
    {
        $result = $this->service->delete($this->data['id']);
        $this->assertIsBool($result);
    }
}
