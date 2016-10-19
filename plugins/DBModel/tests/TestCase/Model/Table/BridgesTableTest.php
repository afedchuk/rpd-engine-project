<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\BridgesTable;

/**
 * DBModel\Model\Table\BridgesTable Test Case
 */
class BridgesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\BridgesTable
     */
    public $Bridges;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.bridges',
        'plugin.d_b_model.engines'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Bridges') ? [] : ['className' => 'DBModel\Model\Table\BridgesTable'];
        $this->Bridges = TableRegistry::get('Bridges', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bridges);

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
            'hostname' => 'localhost',
            'despatcher' => 'nsh://localhost',
            'platform' => 'Windows-x64',
            'remote_platform' => '0',
            'channel_type_id' => 1,
            'vm_id' => 1,
            'zone_id' => 1,
            'agent_info' => 'information',
            'agent_up' => 1,
            'agent_writable' => 1
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
        $bridge = $this->Bridges->newEntity($data);
        $this->assertEmpty($bridge->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['hostname']);
        unset($data['despatcher']);
        unset($data['platform']);
        unset($data['remote_platform']);
        unset($data['channel_type_id']);
        unset($data['vm_id']);
        unset($data['zone_id']);
        unset($data['agent_info']);
        unset($data['agent_up']);
        unset($data['agent_writable']);
        $bridge = $this->Bridges->newEntity($data);
        $this->assertEmpty($bridge->errors());
    }

    /**
     * Test getValidServers method.
     *
     * @return void
     */
    public function testGetValidServers()
    {
        $validServers = $this->Bridges->getValidServers();
        $this->assertNotEmpty($validServers);
        $result = $this
                    ->Bridges
                    ->find()
                    ->select('id')
                    ->toArray();
        foreach ($result as $value) {
            $this->assertArrayHasKey($value['id'], $validServers);
        }
    }
    
    /**
     * Test getZoneServerList method.
     *
     * @return void
     */
    public function testGetZoneServerList()
    {
        $this->Engines = TableRegistry::get('Engines', ['className' => 'DBModel\Model\Table\EnginesTable']);
        $this->Engines->engineId = set('engineId', 0);
        $result = $this->Bridges->getZoneServerList();
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey(0, $result);
    }
}
