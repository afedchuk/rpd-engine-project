<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\DeliveryProcessesTable;

/**
 * DBModel\Model\Table\DeliveryProcessesTable Test Case
 */
class DeliveryProcessesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\DeliveryProcessesTable
     */
    public $DeliveryProcesses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.delivery_processes',
        'plugin.d_b_model.processes',
        'plugin.d_b_model.deliveries',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DeliveryProcesses') ? [] : ['className' => 'DBModel\Model\Table\DeliveryProcessesTable'];
        $this->DeliveryProcesses = TableRegistry::get('DeliveryProcesses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DeliveryProcesses);

        parent::tearDown();
    }

    /**
     * getCorrectData method
     *
     * @return array
     */
    private function getCorrectData()
    {
        $data = [
            'paths' => 'text.txt',
            'status' => 'VirtualFail',
            'pattern' => 'pattern',
            'provision_process_id' => 0,
            'process_id' => 1,
            'channel_id' => 0,
            'handler_id' => 0,
            'solid_id' => 0,
            'delivery_id' => 1
        ];
        return $data;
    }

    /**
     * Test validationDefault method. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultCorrect()
    {
        $data = $this->getCorrectData();
        $deliveryProcess = $this->DeliveryProcesses->newEntity($data);
        $this->assertEmpty($deliveryProcess->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['delivery_id']);
        unset($data['solid_id']);
        unset($data['handler_id']);
        unset($data['channel_id']);
        unset($data['process_id']);
        unset($data['provision_process_id']);
        unset($data['pattern']);
        unset($data['status']);
        unset($data['paths']);
        $deliveryProcess = $this->DeliveryProcesses->newEntity($data);
        $this->assertEmpty($deliveryProcess->errors());
    }
    
    /**
     * Test consistencyCheck method.
     *
     * @return void
     */
    public function testConsistencyCheck()
    {
        $this->Processes = TableRegistry::get('Processes', ['className' => 'DBModel\Model\Table\ProcessesTable']);
        $processes = $this->Processes->find('all')
                        ->where(['flag' => 'QUEUED'])
                        ->contain(['DeliveryProcesses'])
                        ->first();
        $result = $this->DeliveryProcesses->consistencyCheck();
        $process = $this->Processes->get($processes->id);
        $this->assertEquals('CANCELLED', $process->flag);
        $this->assertTrue($result);
    }
}
