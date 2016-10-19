<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActivityDependsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ActivityDependsTable Test Case
 */
class ActivityDependsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ActivityDependsTable
     */
    public $ActivityDepends;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.activity_depends',
        'app.activities',
        'app.def_depends'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ActivityDepends') ? [] : ['className' => 'App\Model\Table\ActivityDependsTable'];
        $this->ActivityDepends = TableRegistry::get('ActivityDepends', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ActivityDepends);

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
