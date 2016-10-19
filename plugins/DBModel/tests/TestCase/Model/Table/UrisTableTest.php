<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\UrisTable;

/**
 * DBModel\Model\Table\UrisTable Test Case
 */
class UrisTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\UrisTable
     */
    public $Uris;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.uris',
        'plugin.d_b_model.asset_properties',
        'plugin.d_b_model.bridges',
       ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Uris') ? [] : ['className' => 'DBModel\Model\Table\UrisTable'];
        $this->Uris = TableRegistry::get('Uris', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Uris);

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
