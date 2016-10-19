<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\AssetRolesTable;

/**
 * DBModel\Model\Table\AssetRolesTable Test Case
 */
class AssetRolesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\AssetRolesTable
     */
    public $AssetRoles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.asset_roles',
        'plugin.d_b_model.assets',
        'plugin.d_b_model.access_groups'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AssetRoles') ? [] : ['className' => 'DBModel\Model\Table\AssetRolesTable'];
        $this->AssetRoles = TableRegistry::get('AssetRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AssetRoles);

        parent::tearDown();
    }
    /**
     * getCorrectData method
     *
     * @return array
     */
    private function getCorrectData()
    {
        $data = ['asset_id'=> 1, 
                'role_id' => 1];
        return $data;
    }
    
    /**
     * Test validationDefault method. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultCorrect()
    {   
        $data = $this->getCorrectData();
        $assetRole = $this->AssetRoles->newEntity($data);
        $this->assertEmpty($assetRole->errors());
    }

    /**
     * Test validationDefault method. Expecting validation error for empty propery name.
     *
     * @return void
     */
    public function testValidationDefaultAssetId()
    {   
        $data = $this->getCorrectData();
        unset($data['asset_id']);
        $assetRole = $this->AssetRoles->newEntity($data);
        $expected = ['asset_id' => [
                        "_required" => "This field is required"]
                    ];
        $this->assertNotEmpty($assetRole->errors());
        $this->assertEquals($expected, $assetRole->errors());
    }

    /**
     * Test validationDefault method. Expecting validation error for empty propery value.
     *
     * @return void
     */
    public function testValidationDefaultNoRoleId()
    {   
        $data = $this->getCorrectData();
        unset($data['role_id']);
        $assetRole = $this->AssetRoles->newEntity($data);
         $expected = ['role_id' => [
                        "_required" => "This field is required"]
                    ];
        $this->assertNotEmpty($assetRole->errors());
        $this->assertEquals($expected, $assetRole->errors());
    }
}
