<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\DeliveriesTable;

/**
 * DBModel\Model\Table\DeliveriesTable Test Case
 */
class DeliveriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\DeliveriesTable
     */
    public $Deliveries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.deliveries',
        'plugin.d_b_model.deliverables',
        'plugin.d_b_model.assets'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Deliveries') ? [] : ['className' => 'DBModel\Model\Table\DeliveriesTable'];
        $this->Deliveries = TableRegistry::get('Deliveries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Deliveries);

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
            'deliverable_id' => 1,
            'user_id' => 1,
            'type' => 'D',
            'del_env_id' => 1,
            'action' => 'go',
            'delivery_id' => 1,
            'gmt_created' => 1451052847,
            'pre_process_id' => 0,
            'post_process_id' => 0,
            'vm_process_id' => 0,
            'engine_id' => 1,
            'status' => 'pass',
            'pause_after' => 'none',
            'gmt_start' => 1451052856,
            'duration' => 9,
            'active_pool_id' => 0,
            'target_pool' => 'pool',
            'drift_execs_failure' => 0
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
        $delivery = $this->Deliveries->newEntity($data);
        $this->assertEmpty($delivery->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['deliverable_id']);
        unset($data['user_id']);
        unset($data['type']);
        unset($data['del_env_id']);
        unset($data['action']);
        unset($data['delivery_id']);
        unset($data['gmt_created']);
        unset($data['pre_process_id']);
        unset($data['post_process_id']);
        unset($data['engine_id']);
        unset($data['status']);
        unset($data['pause_after']);
        unset($data['gmt_start']);
        unset($data['duration']);
        unset($data['active_pool_id']);
        unset($data['target_pool']);
        unset($data['drift_execs_failure']);
        $delivery = $this->Deliveries->newEntity($data);
        $this->assertEmpty($delivery->errors());
    }

    /**
     * Test engineClean method
     *
     * @return void
     */
    public function testEngineClean()
    {
        $deliveryId = 1;
        $data = $this
                    ->Deliveries
                    ->find()
                    ->where(['id' => $deliveryId])
                    ->toArray();
        $this->assertNotEquals(0, $data[0]->engine_id);
        $result = $this->Deliveries->engineClean($data);
        $this->assertTrue($result);
        $record = $this->Deliveries->get($deliveryId);
        $this->assertEquals(0, $record->engine_id);
    }
}
