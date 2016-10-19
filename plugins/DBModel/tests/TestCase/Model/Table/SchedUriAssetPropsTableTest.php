<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\SchedUriAssetPropsTable;

/**
 * DBModel\Model\Table\SchedUriAssetPropsTable Test Case
 */
class SchedUriAssetPropsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\SchedUriAssetPropsTable
     */
    public $SchedUriAssetProps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.sched_uri_asset_props',
        'plugin.d_b_model.properties'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SchedUriAssetProps') ? [] : ['className' => 'DBModel\Model\Table\SchedUriAssetPropsTable'];
        $this->SchedUriAssetProps = TableRegistry::get('SchedUriAssetProps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SchedUriAssetProps);

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
