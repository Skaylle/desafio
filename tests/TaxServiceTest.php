<?php
require_once 'AbstractTest.php';

use App\Services\TaxService;

class TaxServiceTest extends AbstractTest
{
    protected TaxService $taxService;

    protected array $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taxService = new TaxService();
        $this->data =  $this->testAbstractCrateTax();
    }

    /**
     * @covers App\Services\TaxService::index
     */
    public function testIndex()
    {
        $this->testAbstractCrateTax();
        $result = $this->taxService->index();
        $this->assertIsArray($result);
    }

    /**
     * @covers App\Services\TaxService::create
     */
    public function testCreate()
    {
        $this->assertIsArray($this->data);
    }

    /**
     * @covers App\Services\TaxService::find
     */
    public function testFind()
    {
        $result = $this->taxService->find($this->data['id']);
        $this->assertNotNull($result);
    }

    /**
     * @covers App\Services\TaxService::update
     */
    public function testUpdate()
    {
        $result = $this->taxService->update($this->data['id'], ['name' => 'TESTE', 'description' => 'TESTE UPDATE']);
        $this->assertIsArray($result);
    }

    /**
     * @covers App\Services\TaxService::delete
     */
    public function testDelete()
    {
        $result = $this->taxService->delete($this->data['id']);
        $this->assertIsBool($result);
    }
}
