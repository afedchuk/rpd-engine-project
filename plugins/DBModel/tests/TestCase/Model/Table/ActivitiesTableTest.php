<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\ActivitiesTable;

/**
 * DBModel\Model\Table\ActivitiesTable Test Case
 */
class ActivitiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\ActivitiesTable
     */
    public $Activities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.activities',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Activities') ? [] : ['className' => 'DBModel\Model\Table\ActivitiesTable'];
        $this->Activities = TableRegistry::get('Activities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Activities);

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
            'name' => 'Sample File Deploy Activity',
            'process_id' => 1,
            'def_activity_id' => 1,
            'lib_activity_id' => 1,
            'flag' => 'COMPLETE',
            'gmt_start' => 1451052860,
            'duration' => 30,
            'activity_timeout' => 0
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
        $activity = $this->Activities->newEntity($data);
        $this->assertEmpty($activity->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['name']);
        unset($data['process_id']);
        unset($data['def_activity_id']);
        unset($data['lib_activity_id']);
        unset($data['flag']);
        $activity = $this->Activities->newEntity($data);
        $this->assertEmpty($activity->errors());
    }

    /**
     * Test testBusy method for valid flag
     *
     * @return void
     */
    public function testBusyValidField()
    {
        $flag = $this->Activities::COMPLETE;
        $activity = $this->Activities->busy($flag, $this->Activities::$busyStatus);
        $this->assertFalse($activity);
    }

    /**
     * Test testBusy method for invalid flag
     *
     * @return void
     */
    public function testBusyInvalidField()
    {
        $invalidFlag = 'INVALID_FLAG';
        $result = $this->Activities->busy($invalidFlag, $this->Activities::$busyStatus);
        $this->assertTrue($result);
    }

    /**
     * Test setFlag method for new flag.
     *
     * @return void
     */
    public function testSetFlag()
    {
        $activityId = 1; // activity ID
        $result = $this->Activities->setFlag($activityId, 'NEW_FLAG');
        $this->assertTrue($result);
        $newFlag = $this->Activities
                    ->find()
                    ->select(['flag'])
                    ->where(['id' => $activityId])
                    ->first();
        $this->assertEquals('NEW_FLAG', $newFlag->flag);
    }

    /**
     * Test setFlag method for the existing flag.
     *
     * @return void
     */
    public function testSetExistingFlag()
    {
        $activityId = 2; // activity ID
        $activityGmtStart = $this->Activities
                    ->find()
                    ->select(['gmt_start'])
                    ->where(['id' => $activityId])
                    ->first();
        $result = $this->Activities->setFlag($activityId, $this->Activities::SKIPPED, $this->Activities::$status);
        $this->assertTrue($result);
        $activity = $this->Activities
                    ->find()
                    ->select(['duration', 'flag'])
                    ->where(['id' => $activityId])
                    ->first();
        $this->assertEquals(time() - $activityGmtStart->gmt_start, $activity->duration);
        $this->assertEquals($this->Activities::SKIPPED, $activity->flag);
    }

    /**
     * Test setFlag method for the 'ACTIVE' flag.
     *
     * @return void
     */
    public function testSetActiveFlag()
    {
        $activityId = 1; // activity ID
        $result = $this->Activities->setFlag($activityId, $this->Activities::ACTIVE, $this->Activities::$status);
        $this->assertTrue($result);
        $activity = $this->Activities
                    ->find()
                    ->select(['gmt_start', 'duration', 'flag'])
                    ->where(['id' => $activityId])
                    ->first();
        $this->assertEquals(time(), $activity->gmt_start);
        $this->assertEquals(time() - $activity->gmt_start, $activity->duration);
        $this->assertEquals($this->Activities::ACTIVE, $activity->flag);
    }
}
