<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\ProcessesTable;

/**
 * DBModel\Model\Table\ProcessesTable Test Case
 */
class ProcessesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\ProcessesTable
     */
    public $Processes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.processes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        TableRegistry::remove('Processes');
        $config = TableRegistry::exists('Processes') ? [] : ['className' => 'DBModel\Model\Table\ProcessesTable'];
        $this->Processes = TableRegistry::get('Processes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Processes);

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
            'def_process_id' => 1,
            'name' => 'Initialize Virtual Machines',
            'type' => 'Virtual',
            'flag' => 'COMPLETE',
            'engine_id' => 0,
            'gmt_flag' => 1451053499,
            'gmt_start' => 1451053499,
            'duration' => 0,
            'message' => 'Processing'
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
        $process = $this->Processes->newEntity($data);
        $this->assertEmpty($process->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['def_process_id']);
        unset($data['name']);
        unset($data['type']);
        unset($data['flag']);
        unset($data['duration']);
        $process = $this->Processes->newEntity($data);
        $this->assertEmpty($process->errors());
    }

    /**
     * Test setFlag method for new flag.
     *
     * @return void
     */
    public function testSetFlag()
    {
        $processId = 1; // process ID
        $flag = 'NEW_FLAG';
        $result = $this->Processes->setFlag($processId, $flag);
        $this->assertTrue($result);
        $newFlag = $this->Processes
                    ->find()
                    ->select(['flag'])
                    ->where(['id' => $processId])
                    ->first();
        $this->assertEquals($flag, $newFlag->flag);
    }

    /**
     * Test setFlag method for the existing flag.
     *
     * @return void
     */
    public function testSetExistingFlag()
    {
        $processId = 2; // process ID
        $flag = $this->Processes::DONE;
        $processGmtStart = $this->Processes
                    ->find()
                    ->select(['gmt_start'])
                    ->where(['id' => $processId])
                    ->first();
        $result = $this->Processes->setFlag($processId, $flag, $this->Processes::$status);
        $this->assertTrue($result);
        $process = $this->Processes
                    ->find()
                    ->select(['duration', 'flag'])
                    ->where(['id' => $processId])
                    ->first();
        $this->assertEquals(time() - $processGmtStart->gmt_start, $process->duration);
        $this->assertEquals($flag, $process->flag);
    }

    /**
     * Test setFlag method for the 'ACTIVE' flag.
     *
     * @return void
     */
    public function testSetActiveFlag()
    {
        $processId = 2; // process ID
        $flag = $this->Processes::ACTIVE;
        $result = $this->Processes->setFlag($processId, $flag, $this->Processes::$status);
        $this->assertTrue($result);
        $process = $this->Processes
                    ->find()
                    ->select(['gmt_start', 'duration', 'flag'])
                    ->where(['id' => $processId])
                    ->first();
        $this->assertEquals(time(), $process->gmt_start);
        $this->assertEquals(time() - $process->gmt_start, $process->duration);
        $this->assertEquals($flag, $process->flag);
    }

    /**
     * Test engineClean method.
     *
     * @return void
     */
    public function testEngineClean()
    {
        $processId = 4;
        $data = $this
                    ->Processes
                    ->find()
                    ->where(['id' => $processId])
                    ->toArray();
        $this->assertNotEquals(0, $data[0]->engine_id);
        $result = $this->Processes->engineClean($data);
        $this->assertTrue($result);
        $record = $this->Processes->get($processId);
        $this->assertEquals(0, $record->engine_id);
        $this->assertEquals($this->Processes::STOPPED, $record->flag);
    }
}
