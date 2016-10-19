<?php
namespace DBModel\Test\TestCase\Model\Table;

use DBModel\Model\Table\AssetsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssetsTable Test Case
 */
class AssetsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssetsTable
     */
    public $Assets;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.assets',
        // 'plugin.d_b_model.products',
        'plugin.d_b_model.asset_properties',
        // 'plugin.d_b_model.asset_roles',
        'plugin.d_b_model.deliverables',
        'plugin.d_b_model.del_route_names',
        'plugin.d_b_model.artifacts',
        'plugin.d_b_model.deliveries',
        'plugin.d_b_model.deliverable_roles',
        'plugin.d_b_model.solids',
        // 'plugin.d_b_model.delivery_previews',
        // 'plugin.d_b_model.spin_previews',
        // 'plugin.d_b_model.uris'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Assets') ? [] : ['className' => 'DBModel\Model\Table\AssetsTable'];
        $this->Assets = TableRegistry::get('Assets', $config);
    }

    public function testIncrementRev()
    {
        $result = $this->Assets->incrementRev(2); //2 is ID of the Asset
        $this->assertInstanceOf('Cake\Database\Statement\PDOStatement', $result);

        $asset = $this->Assets->findById(2)->first();
        $this->assertEquals(3 ,$asset->nextrev); // since we populated asset (ID=2) field nextrev with value 2 , after execution it should be incremented to 3.
    }

    public function testDeleteSchedsData()
    {
        $this->assertTrue(true); // it is only definition of method. Implementation will be resumed when related Schedule models and fixtures will be covered
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Assets);

        parent::tearDown();
    }

    // /**
    //  * Test initialize method
    //  *
    //  * @return void
    //  */
    // public function testInitialize()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test validationDefault method
    //  *
    //  * @return void
    //  */
    // public function testValidationDefault()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test buildRules method
    //  *
    //  * @return void
    //  */
    // public function testBuildRules()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }
}
