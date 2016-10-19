<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\EnginesTable;

/**
 * DBModel\Model\Table\EnginesTable Test Case
 */
class EnginesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\EnginesTable
     */
    public $Engines;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.engines',
        'plugin.d_b_model.engine_hosts',
        'plugin.d_b_model.zones',
        'plugin.d_b_model.tasks',
        'plugin.d_b_model.processes',
        'plugin.d_b_model.deliveries'
    ];

    /**
     * getCorrectData method
     *
     * @return array
     */
    private function getCorrectData()
    {
        $data = [
            'hostname' => 'Remotehost',
            'pid' => 1844,
            'port' => 34242,
            'gmt_created' => 1,
            'gmt_expires' => 1,
            'count' => 1,
            'activity' => 'Lorem ipsum dolor sit amet',
            'control' => 'Lorem ipsum dolor sit amet',
            'host_session_key' => 'asxxx-sf414-1134'
        ];
        return $data;
    }

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Engines') ? [] : ['className' => 'DBModel\Model\Table\EnginesTable'];
        $this->Engines = TableRegistry::get('Engines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Engines);
        unset($this->Processes);
        unset($this->EngineHosts);
        unset($this->Tasks);
        unset($this->Zones);
        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test register method
     *
     * @return void
     */
    public function testRegister()
    {
        $correctData = $this->getCorrectData();
        $result = $this->Engines->register($correctData['hostname'], $correctData['pid'], $correctData['host_session_key'], $correctData['port']);
        $this->assertTrue($result);
    }

    /**
     * Test register method. Tring to reregister the same engine.
     *
     * @return void
     */
    public function testReRegister()
    {
        $correctData = $this->getCorrectData();
        $result = $this->Engines->register($correctData['hostname'], $correctData['pid'], $correctData['host_session_key'], $correctData['port']);
        $this->assertTrue($result);
        $result = $this->Engines->register($correctData['hostname'], $correctData['pid'], $correctData['host_session_key'], $correctData['port']);
        $this->assertFalse($result);
    }

    /**
     * Test setEngineActivity method
     *
     * @return void
     */
    public function testSetEngineActivityWithIdleFlag()
    {
        $engine = $this->Engines->find()->first();
        $result = $this->Engines->setEngineActivity("Idle", $engine);
        $this->assertTrue($result);
    }

    /**
     * Test setEngineActivity method. Non idle status
     *
     * @return void
     */
    public function testSetEngineActivityWithNonIdleFlag()
    {
        $engine = $this->Engines->find()->first();
        $result = $this->Engines->setEngineActivity("Monitor", $engine);
        $this->assertTrue($result);
    }

    /**
     * Test kill method
     *
     * @return void
     */
    public function testKill()
    {
        $engine = $this->Engines->find()->first();
        $result = $this->Engines->kill($engine->hostname, $engine->pid);
        $this->assertTrue($result);
    }

    /**
     * Test kill method. Non existsing engine
     *
     * @return void
     */
    public function testKillNoRecord()
    {
        $result = $this->Engines->kill("ababagalamaga", '1231');
        $this->assertTrue($result);
    }

    /**
     * Test pulseCheckClean method
     *
     * @return void
     */
    public function testPulseCheckClean()
    {
        $engine = $this->Engines->find()->first();
        $result = $this->Engines->pulseCheckClean($engine->id, 0);
        $this->assertTrue($result);
    }

    /**
     * Test pulseCheckClean method. Non existing record
     *
     * @return void
     */
    public function testPulseCheckCleanNoRecord()
    {
        $result = $this->Engines->pulseCheckClean(999999, 0);
        $this->assertFalse($result);
    }

    /**
     * Test cleanup method
     *
     * @return void
     */
    public function testCleanup()
    {
        $engine = $this->Engines->find()->first();
        $result = $this->Engines->cleanup($engine->id);
        $this->assertTrue($result);
    }

    /**
     * Test cleanup method. Non existing record in DB
     *
     * @return void
     */
    public function testCleanupNoRecord()
    {
        $result = $this->Engines->cleanup(999999);
        $this->assertTrue($result);
    }

    /**
     * Test getMyZone method
     *
     * @return void
     */
    public function testGetMyZone()
    {
        $engine = $this->Engines->find()->where(['hostname'=>'WithZones'])->first();
        $result = $this->Engines->getMyZone($engine->id);
        $this->assertNotEmpty($result);
        $this->assertEquals($result->id, 2);
        $this->assertEquals($result->name, "EnginesZone");
    }

    /**
     * Test getMyZone method. Non existing
     *
     * @return void
     */
    public function testGetMyZoneNoRecord()
    {
        $result = $this->Engines->getMyZone(999999);
        $this->assertFalse($result);
    }
}
