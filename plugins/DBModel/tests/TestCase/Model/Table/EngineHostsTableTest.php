<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\EngineHostsTable;

/**
 * DBModel\Model\Table\EngineHostsTable Test Case
 */
class EngineHostsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\EngineHostsTable
     */
    public $EngineHosts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.engine_hosts',
        'plugin.d_b_model.zones',
        'plugin.d_b_model.engines',
        'plugin.d_b_model.build_checkouts',
        'plugin.d_b_model.deliveries',
        'plugin.d_b_model.processes',
        'plugin.d_b_model.solids',
        'plugin.d_b_model.tasks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('EngineHosts') ? [] : ['className' => 'DBModel\Model\Table\EngineHostsTable'];
        $this->EngineHosts = TableRegistry::get('EngineHosts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EngineHosts);

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
            'hostname' => 'WIN-LSMP86NLKC0',
            'session_key' => '567d4f03-8d38-4393-94e0-0f3458f09a97',
            'max_engines' => 2,
            'gmt_expires' => 1451061808,
            'zone_id' => 0
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
        $engineHost = $this->EngineHosts->newEntity($data);
        $this->assertEmpty($engineHost->errors());
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
        unset($data['session_key']);
        unset($data['max_engines']);
        unset($data['gmt_expires']);
        unset($data['zone_id']);
        $engineHost = $this->EngineHosts->newEntity($data);
        $this->assertEmpty($engineHost->errors());
    }

    /**
     * Test tick method
     *
     * @return void
     */
    public function testTick()
    {
        $hostname = 'WithZones';
        $zombieCheck = 300;
        $record = $this
                    ->EngineHosts
                    ->find()
                    ->where(['hostname' => $hostname, 'gmt_expires <' => time()])
                    ->first();
        $result = $this->EngineHosts->tick($hostname);
        $this->assertTrue($result);
        $entity = $this->EngineHosts->get($record->id);
        $this->assertEquals(time() + $zombieCheck, $entity->gmt_expires);
    }

    /**
     * Test tick method
     *
     * @return void
     */
    public function testTickNoHostname()
    {
        $hostname = 'not_existing_hostname';
        $result = $this->EngineHosts->tick($hostname);
        $this->assertFalse($result);
    }

    /**
     * Test register method
     *
     * @return void
     */
    public function testRegisterWithoutKey()
    {
        $result = $this->EngineHosts->register();
        $this->assertFalse($result);
    }

    /**
     * Test register method
     *
     * @return void
     */
    public function testRegisterWithKey()
    {
        $key = '567d4f03-8d38-4393-94e0-0f3458f09a97';
        if (php_uname('n') == 'base-rhel6x64') {
            $newEntity = $this->EngineHosts->newEntity([
                'hostname' => 'base-rhel6x64',
                'session_key' => '526d1i02-4j25-3654-25e0-1k6511k21a32',
                'max_engines' => 1,
                'gmt_expires' => 1475070262,
                'zone_id' => 1
            ]);
            $this->EngineHosts->save($newEntity);
            $result = $this->EngineHosts->register($key);
            $this->assertTrue($result);
        } else {
           $result = $this->EngineHosts->register($key); // method does not return anything 
           $this->assertEmpty($result);
        }
    }

    /**
     * Test pulseCheck method
     *
     * @return void
     */
    public function testPulseCheck()
    {
        $zombieCheck = 400;
        $result = $this->EngineHosts->pulseCheck($zombieCheck);
        $engineHosts = $this
                        ->EngineHosts
                        ->find('all')
                        ->contain(['Engines', 'Engines.Tasks'])
                        ->toArray();
        foreach ($engineHosts as $engineHost) {
            if (!empty($engineHost->engines)) {
                $this->assertEquals(['clean' => [$engineHost->engines[0]->id]], $result);
            }
        }
    }

    /**
     * Test pulseCheck method if zombieCheck is bigger than timestamp
     *
     * @return void
     */
    public function testPulseCheckBigZombieCheck()
    {
        $zombieCheck = 1475656089;
        $result = $this->EngineHosts->pulseCheck($zombieCheck);
        $engineHosts = $this
                        ->EngineHosts
                        ->find('all')
                        ->contain(['Engines', 'Engines.Tasks'])
                        ->toArray();
        foreach ($engineHosts as $engineHost) {
            if (!empty($engineHost->engines)) {
                $this->assertEquals(['assign' => [$engineHost->engines[0]->id]], $result);
            }
        }
    }
}
