<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\TaskParamOptsTable;

/**
 * DBModel\Model\Table\TaskParamOptsTable Test Case
 */
class TaskParamOptsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\TaskParamOptsTable
     */
    public $TaskParamOpts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.task_param_opts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TaskParamOpts') ? [] : ['className' => 'DBModel\Model\Table\TaskParamOptsTable'];
        $this->TaskParamOpts = TableRegistry::get('TaskParamOpts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TaskParamOpts);

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
