<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\TasksTable;

/**
 * DBModel\Model\Table\TasksTable Test Case
 */
class TasksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\TasksTable
     */
    public $Tasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.tasks',
        'plugin.d_b_model.loches',
        'plugin.d_b_model.task_feeds',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        TableRegistry::remove('Tasks');
        $config = TableRegistry::exists('Tasks') ? [] : ['className' => 'DBModel\Model\Table\TasksTable'];
        $this->Tasks = TableRegistry::get('Tasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tasks);

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
            'name' => 'new_task_name',
            'activity_id' => 2,
            'lib_task_id' => 18,
            'engine_id' => 0,
            'channel_rev_id' => 1,
            'explode_type' => 'NONE',
            'module' => 'file_put',
            'flag' => 'ACTIVE',
            'gmt_start' => 1451052860,
            'duration' => 4,
            'bridge_id' => 1
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
        $task = $this->Tasks->newEntity($data);
        $this->assertEmpty($task->errors());
    }

    /**
     * Test validationDefault method if any fields are empty
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['activity_id']);
        unset($data['name']);
        $task = $this->Tasks->newEntity($data);
        $this->assertEmpty($task->errors());
    }

    /**
     * Test testBusy method for valid flag
     *
     * @return void
     */
    public function testBusyValidField()
    {
        $status = $this->Tasks::DONE;
        $task = $this->Tasks->busy($status, $this->Tasks::$busyStatus);
        $this->assertFalse($task);
    }

    /**
     * Test testBusy method for invalid flag
     *
     * @return void
     */
    public function testBusyInvalidField()
    {
        $invalidStatus = 'INVALID_FLAG';
        $result = $this->Tasks->busy($invalidStatus, $this->Tasks::$busyStatus);
        $this->assertTrue($result);
    }

    /**
     * Test setFlag method
     *
     * @return void
     */
    public function testSetFlag()
    {
        $taskId = 1; // task ID
        $result = $this->Tasks->setFlag($taskId, 'NEW_FLAG');
        $this->assertTrue($result);
        $newFlag = $this->Tasks
                    ->find()
                    ->select(['flag'])
                    ->where(['id' => $taskId])
                    ->first();
        $this->assertEquals('NEW_FLAG', $newFlag->flag);
    }

    /**
     * Test engineClean method
     *
     * @return void
     */
    public function testEngineClean()
    {
        $taskId = 2;
        $data = $this
                    ->Tasks
                    ->find()
                    ->where(['id' => $taskId])
                    ->toArray();
        $result = $this->Tasks->engineClean($data);
        $this->assertTrue($result);
        $record = $this->Tasks->get($taskId);
        $this->assertEquals($this->Tasks::STOPPED, $record->flag);
    }

    /**
     * Test consistencyHook method
     *
     * @return void
     */
    public function testConsistencyHook()
    {
        $taskId = 2;
        $entity = $this->Tasks->get($taskId);
        $result = $this->Tasks->consistencyHook($entity);

        $this->TaskFeeds = TableRegistry::get('TaskFeeds');
        $field = $this
                    ->TaskFeeds
                    ->find()
                    ->select(['line'])
                    ->order(['id' => 'desc'])
                    ->first()
                    ->toArray()['line'];
        $this->assertEquals("Engine process shutdown for unknown reason.", $field);
    }
}