<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\ZonePropertiesTable;

/**
 * DBModel\Model\Table\ZonePropertiesTable Test Case
 */
class ZonePropertiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\ZonePropertiesTable
     */
    public $ZoneProperties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.zone_properties',
        'plugin.d_b_model.zones'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ZoneProperties') ? [] : ['className' => 'DBModel\Model\Table\ZonePropertiesTable'];
        $this->ZoneProperties = TableRegistry::get('ZoneProperties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ZoneProperties);

        parent::tearDown();
    }

    /**
     * getCorrectData method
     *
     * @return array
     */
    private function getCorrectData()
    {
        $data = [
            'name' => 'before_save_zone_property_name',
            'value' => 'before_save_zone_property_value',
            'zone_id' => 1,
            'encrypt_data' => 1                 
        ];
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
        $zoneProperty = $this->ZoneProperties->newEntity($data);
        $this->assertEmpty($zoneProperty->errors());
    }

    /**
     * Test validationDefault method. Expecting validation error for empty name.
     *
     * @return void
     */
    public function testValidationDefaultNoName()
    {   
        $data = $this->getCorrectData();
        $data['name'] = NULL;
        $zoneProperty = $this->ZoneProperties->newEntity($data);
        $expectedResult = ['name' => [
                         "_empty" => "This field cannot be left empty", 
                        ]
                    ];
        $this->assertNotEmpty($zoneProperty->errors());
        $this->assertEquals($expectedResult, $zoneProperty->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyField()
    {   
        $data = $this->getCorrectData();
        $data['value'] = NULL;
        $data['zone_id'] = NULL;
        $zoneProperty = $this->ZoneProperties->newEntity($data);
        $this->assertEmpty($zoneProperty->errors());
    }

    /**
     * Test beforeSave method.
     *
     * @return void
     */
    public function testBeforeSave()
    {
        $data = $this->getCorrectData();
        $entity = $this->ZoneProperties->newEntity($data);
        $this->ZoneProperties->save($entity);
        $lastProperty = $this->ZoneProperties
                            ->find()
                            ->order(['id' => 'DESC'])
                            ->first();
        $this->assertNotEquals('before_save_zone_property_value', $lastProperty->value);

        // disable encryption
        $data['encrypt_data'] = 0 ;
        $entity = $this->ZoneProperties->newEntity($data);
        $this->ZoneProperties->save($entity);
        $lastProperty = $this->ZoneProperties
                            ->find()
                            ->order(['id' => 'DESC'])
                            ->first();
        $this->assertEquals('before_save_zone_property_value', $lastProperty->value);
    }
}
