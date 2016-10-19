<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\TaskFeedsTable;

/**
 * DBModel\Model\Table\TaskFeedsTable Test Case
 */
class TaskFeedsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\TaskFeedsTable
     */
    public $TaskFeeds;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.task_feeds',
        'plugin.d_b_model.tasks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TaskFeeds') ? [] : ['className' => 'DBModel\Model\Table\TaskFeedsTable'];
        $this->TaskFeeds = TableRegistry::get('TaskFeeds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TaskFeeds);

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
            'task_id' => 1,
            'gmt_created' => 1451054009,
            'line' => 'BLPASSWORD=awwtgl01@',
            'flag' => 'P'
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
        $taskFeed = $this->TaskFeeds->newEntity($data);
        $this->assertEmpty($taskFeed->errors());
    }

    /**
     * Test validationDefault method if any fields are empty
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['task_id']);
        unset($data['gmt_created']);
        unset($data['line']);
        unset($data['flag']);
        $taskFeed = $this->TaskFeeds->newEntity($data);
        $this->assertEmpty($taskFeed->errors());
    }

    /**
     * Test putLine method
     *
     * @return void
     */
    public function testPutLine()
    {
        $taskId = 2;
        $text = 'VL_ACTIVITY_ID=8';
        $flag = 'P';
        $result = $this->TaskFeeds->putLine($taskId, $text, $flag);
        $this->assertTrue($result);
        $entity = $this->TaskFeeds->find()->where(['task_id' => $taskId, 'line' => $text, 'flag' => $flag])->first();
        $this->assertNotEmpty($entity);
        $this->assertInstanceOf('DBModel\Model\Entity\TaskFeed', $entity);
    }
}
