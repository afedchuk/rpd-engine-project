<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\DefActivitiesTable;

/**
 * DBModel\Model\Table\DefActivitiesTable Test Case
 */
class DefActivitiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\DefActivitiesTable
     */
    public $DefActivities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.def_activities'];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DefActivities') ? [] : ['className' => 'DBModel\Model\Table\DefActivitiesTable'];
        $this->DefActivities = TableRegistry::get('DefActivities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DefActivities);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
