<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\DelRouteNamesTable;

/**
 * DBModel\Model\Table\DelRouteNamesTable Test Case
 */
class DelRouteNamesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\DelRouteNamesTable
     */
    public $DelRouteNames;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.del_route_names',
        'plugin.d_b_model.del_routes',
        'plugin.d_b_model.deliverables',
        'plugin.d_b_model.assets',
        'plugin.d_b_model.artifacts',
        'plugin.d_b_model.deliverable_roles',
        'plugin.d_b_model.deliveries',
        // 'plugin.d_b_model.solids'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DelRouteNames') ? [] : ['className' => 'DBModel\Model\Table\DelRouteNamesTable'];
        $this->DelRouteNames = TableRegistry::get('DelRouteNames', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DelRouteNames);

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
