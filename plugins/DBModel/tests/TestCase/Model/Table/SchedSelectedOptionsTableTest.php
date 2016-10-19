<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\SchedSelectedOptionsTable;

/**
 * DBModel\Model\Table\SchedSelectedOptionsTable Test Case
 */
class SchedSelectedOptionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\SchedSelectedOptionsTable
     */
    public $SchedSelectedOptions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.sched_selected_options'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SchedSelectedOptions') ? [] : ['className' => 'DBModel\Model\Table\SchedSelectedOptionsTable'];
        $this->SchedSelectedOptions = TableRegistry::get('SchedSelectedOptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SchedSelectedOptions);

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
