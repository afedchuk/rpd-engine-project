<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\DeliverableRolesTable;

/**
 * DBModel\Model\Table\DeliverableRolesTable Test Case
 */
class DeliverableRolesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\DeliverableRolesTable
     */
    public $DeliverableRoles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.deliverable_roles',
        'plugin.d_b_model.deliverables',
        'plugin.d_b_model.assets',
        'plugin.d_b_model.del_route_names',
        'plugin.d_b_model.artifacts',
        'plugin.d_b_model.deliveries',
        'plugin.d_b_model.solids'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DeliverableRoles') ? [] : ['className' => 'DBModel\Model\Table\DeliverableRolesTable'];
        $this->DeliverableRoles = TableRegistry::get('DeliverableRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DeliverableRoles);

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
