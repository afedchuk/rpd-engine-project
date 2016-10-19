<?php
namespace DBModel\Test\TestCase\Model\Table;

use DBModel\Model\Table\AssetPropertiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssetPropertiesTable Test Case
 */
class AssetPropertiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssetPropertiesTable
     */
    public $AssetProperties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.asset_properties',
        'plugin.d_b_model.assets',
        'plugin.d_b_model.uris'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AssetProperties') ? [] : ['className' => 'DBModel\Model\Table\AssetPropertiesTable'];
        $this->AssetProperties = TableRegistry::get('AssetProperties', $config);
    }
    /**
     * getCorrectData method
     *
     * @return array
     */
    private function getCorrectData()
    {
        $data = [
            'asset_id' => 2,
            'name' => 'before_save_test',
            'value' => 'before_save_value',
            'locked' => 0,
            'encrypt_data' => 1,                      
        ];
        return $data;
    }

    public function testOnBeforeSave()
    {
        $data = $this->getCorrectData();
        $entity = $this->AssetProperties->newEntity($data);
        $this->AssetProperties->save($entity);
        $last_asset = $this->AssetProperties->find()->order(['id' => 'DESC'])->first();

        $this->assertNotEquals('before_save_value', $last_asset->value);
        $data['encrypt_data'] = 0 ;
        $data['value'] = 'before_save_value_second' ;
        $entity = $this->AssetProperties->newEntity($data);

        $this->AssetProperties->save($entity);
        $last_asset = $this->AssetProperties->find()->order(['id' => 'DESC'])->first();

         $this->assertEquals('before_save_value_second', $last_asset->value);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AssetProperties);

        parent::tearDown();
    }

    /**
     * Test validationDefault method. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultCorrect()
    {   
        $data = $this->getCorrectData();
        $assetProperty = $this->AssetProperties->newEntity($data);
        $this->assertEmpty($assetProperty->errors());
    }

    /**
     * Test validationDefault method. Expecting validation error for empty propery asset_id.
     *
     * @return void
     */
    public function testValidationDefaultNoAssetId()
    {   
        $data = $this->getCorrectData();
        $data['asset_id'] = NULL;
        $assetProperty = $this->AssetProperties->newEntity($data);
        $expected = ['asset_id' => [
                         "_empty" => "This field cannot be left empty", 
                        ]
                    ];
        $this->assertNotEmpty($assetProperty->errors());
        $this->assertEquals($expected, $assetProperty->errors());
    }

    /**
     * Test validationDefault method. Expecting validation error for empty name.
     *
     * @return void
     */
    public function testValidationDefaultNoName()
    {   
        $data = $this->getCorrectData();
        unset($data['name']);
        $assetProperty = $this->AssetProperties->newEntity($data);
         $expected = ['name' => [
                        "_required" => "This field is required"]
                    ];
        $this->assertNotEmpty($assetProperty->errors());
        $this->assertEquals($expected, $assetProperty->errors());
    }

    /**
     * Test validationDefault method. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoLocked()
    {   
        $data = $this->getCorrectData();
        unset($data['locked']);
        $assetProperty = $this->AssetProperties->newEntity($data);
        $this->assertEmpty($assetProperty->errors());
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
