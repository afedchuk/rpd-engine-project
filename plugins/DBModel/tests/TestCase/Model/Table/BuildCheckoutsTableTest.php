<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\BuildCheckoutsTable;

/**
 * DBModel\Model\Table\BuildCheckoutsTable Test Case
 */
class BuildCheckoutsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\BuildCheckoutsTable
     */
    public $BuildCheckouts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BuildCheckouts') ? [] : ['className' => 'DBModel\Model\Table\BuildCheckoutsTable'];
        $this->BuildCheckouts = TableRegistry::get('BuildCheckouts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BuildCheckouts);

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
