<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\PropertiesTable;

/**
 * DBModel\Model\Table\PropertiesTable Test Case
 */
class PropertiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\PropertiesTable
     */
    public $Properties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('Properties') ? [] : ['className' => 'DBModel\Model\Table\PropertiesTable'];
        $this->Properties = TableRegistry::get('Properties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Properties);

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
            'name' => 'before_save_name',
            'value' => 'before_save_value',
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
        $property = $this->Properties->newEntity($data);
        $this->assertEmpty($property->errors());
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
        $property = $this->Properties->newEntity($data);
        $expectedResult = ['name' => [
                         "_empty" => "This field cannot be left empty", 
                        ]
                    ];
        $this->assertNotEmpty($property->errors());
        $this->assertEquals($expectedResult, $property->errors());
    }

    /**
     * Test validationDefault method. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoValue()
    {   
        $data = $this->getCorrectData();
        $data['value'] = NULL;
        $property = $this->Properties->newEntity($data);
        $this->assertEmpty($property->errors());
    }

    /**
     * Test beforeSave method.
     *
     * @return void
     */
    public function testBeforeSave()
    {
        $data = $this->getCorrectData();
        $entity = $this->Properties->newEntity($data);
        $this->Properties->save($entity);
        $lastProperty = $this->Properties
                            ->find()
                            ->order(['id' => 'DESC'])
                            ->first();
        $this->assertNotEquals('before_save_value', $lastProperty->value);

        // disable encryption
        $data['encrypt_data'] = 0 ;
        $entity = $this->Properties->newEntity($data);
        $this->Properties->save($entity);
        $lastProperty = $this->Properties
                            ->find()
                            ->order(['id' => 'DESC'])
                            ->first();
        $this->assertEquals('before_save_value', $lastProperty->value);
    }
}
