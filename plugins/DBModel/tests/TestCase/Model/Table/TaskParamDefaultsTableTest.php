<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\TaskParamDefaultsTable;

/**
 * DBModel\Model\Table\TaskParamDefaultsTable Test Case
 */
class TaskParamDefaultsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\TaskParamDefaultsTable
     */
    public $TaskParamDefaults;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.task_param_defaults'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TaskParamDefaults') ? [] : ['className' => 'DBModel\Model\Table\TaskParamDefaultsTable'];
        $this->TaskParamDefaults = TableRegistry::get('TaskParamDefaults', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TaskParamDefaults);

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
