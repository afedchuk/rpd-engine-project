<?php
namespace DBModel\Test\TestCase\Model\Table;

use DBModel\Model\Table\DeliverablesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * DBModel\Model\Table\DeliverablesTable Test Case
 */
class DeliverablesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\DeliverablesTable
     */
    public $Deliverables;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.deliverables',
        'plugin.d_b_model.assets',
        'plugin.d_b_model.asset_properties',
        'plugin.d_b_model.del_route_names',
        'plugin.d_b_model.artifacts',
        'plugin.d_b_model.deliveries',
        'plugin.d_b_model.deliverable_roles',
        'plugin.d_b_model.solids',
        'plugin.d_b_model.loches',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Deliverables') ? [] : ['className' => 'DBModel\Model\Table\DeliverablesTable'];
        $lockConfig = TableRegistry::exists('Loches') ? [] : ['className' => 'DBModel\Model\Table\LochesTable'];
        $assetsConfig = TableRegistry::exists('Assets') ? [] : ['className' => 'DBModel\Model\Table\AssetsTable'];
        $this->Deliverables = TableRegistry::get('Deliverables', $config);
        $this->Assets = TableRegistry::get('Assets', $assetsConfig);
        $this->Loches = TableRegistry::get('Loches', $lockConfig);
    }
    /**
     * Test get delivery with proper counter and engine id.
     *
     * @return int deliveryId
     */
    public function testGetDeliverableId()
    {   
        $counter = 1; // status Construct
        $result = $this->Deliverables->getDeliverableId( 3333 , $counter); // 3333 is engine id
        $deliverable = $this->Deliverables->get($result);
        $lock = $this->Loches->find()->where(['name' => 'deliverables'])->all()->count();
        $this->assertGreaterThan(0, $result);
        $this->assertEquals($deliverable->status, 3333);
        $this->assertEquals($lock, 0);
    }

    /**
     * Test get delivery with proper counter and engine id.
     *
     * @return int deliveryId
     */
    public function testGetDeliverableIdStatusEmpty()
    {   
        $counter = 3; // status Construct
        $result = $this->Deliverables->getDeliverableId( 3333 , $counter); // 3333 is engine id
        $deliverable = $this->Deliverables->get($result);
        $lock = $this->Loches->find()->where(['name' => 'deliverables'])->all()->count();
        $this->assertGreaterThan(0, $result);
        $this->assertEquals($deliverable->status, 3333);
        $this->assertEquals($lock, 0);
    }
    /**
     * Test get delivery with proper counter that is not equal to delivery. Should return 0
     *
     * @return int deliveryId
     */
    public function testGetDeliverableIdWithNonValidCounter()
    {   
        $counter = 2; // Fixture record number 2 with Ready status
        $result = $this->Deliverables->getDeliverableId( 3333 , $counter); // 3333 is engine id
        $lock = $this->Loches->find()->where(['name' => 'deliverables'])->all()->count();
        $this->assertEquals(0, $result);
        $this->assertEquals($lock, 0);
    }

    /**
     * Test get delivery with invalid counter. Counter is greater then records in DB. Should return 0
     *
     * @return int deliveryId
     */
    public function testGetDeliverableIdWithTooBigCounter()
    {   
        $counter = 10000;
        $result = $this->Deliverables->getDeliverableId( 3333 , $counter); // 3333 is engine id
        $lock = $this->Loches->find()->where(['name' => 'deliverables'])->all()->count();
        $this->assertEquals(1, $result);
        $this->assertEquals($lock, 0);
    }

    /**
     * Test get delivery with empty table. Should return 0
     *
     * @return int deliveryId
     */
    public function testGetDeliverableIdWithEmtyTable()
    {   
        $this->Deliverables->deleteAll(['cloaked' => 0]); // delete all data
        $response = [
                      ['deliverables'=>[
                                        'records'=>'No records found'
                                      ]]
                      ];
        $counter = 1;
        $result = $this->Deliverables->getDeliverableId( 3333 , $counter); // 3333 is engine id
        $lock = $this->Loches->find()->where(['name' => 'deliverables'])->all()->count();
        $this->assertEquals($response, $result);
        $this->assertEquals($lock, 0);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Deliverables);

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
