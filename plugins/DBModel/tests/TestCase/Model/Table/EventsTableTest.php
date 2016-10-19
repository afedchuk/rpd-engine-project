<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\EventsTable;

/**
 * DBModel\Model\Table\EventsTable Test Case
 */
class EventsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\EventsTable
     */
    public $Events;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.events',
        'plugin.d_b_model.usrs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Events') ? [] : ['className' => 'DBModel\Model\Table\EventsTable'];
        $this->Events = TableRegistry::get('Events', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Events);

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
            'user_id' => 1,
            'source' => 'Engine',
            'gmt_created' => 1473249270
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
        $event = $this->Events->newEntity($data);
        $this->assertEmpty($event->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['user_id']);
        unset($data['source']);
        unset($data['gmt_created']);
        $event = $this->Events->newEntity($data);
        $this->assertEmpty($event->errors());
    }

    /**
     * Test createEvent method.
     *
     * @return void
     */
    public function testCreateEvent()
    {
        $source = 'Login';
        $userId = 1;
        $result = $this->Events->createEvent($source, $userId);
        $lastID = $this->Events->getInsertID();
        $this->assertEquals($lastID, $result);
    }
}
