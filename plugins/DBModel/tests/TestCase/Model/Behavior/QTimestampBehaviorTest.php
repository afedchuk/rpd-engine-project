<?php
namespace DBModel\Test\TestCase\Model\Behavior;

use Cake\TestSuite\TestCase;
use DBModel\Model\Behavior\QTimestampBehavior;
use Cake\ORM\TableRegistry;

/**
 * DBModel\Model\Behavior\QTimestampBehavior Test Case
 */
class QTimestampBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Behavior\QTimestampBehavior
     */
    public $QTimestamp;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Oddits = TableRegistry::get('Oddits');
        $this->QTimestamp = new QTimestampBehavior($this->Oddits);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->QTimestamp);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
