<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\PlatformPropertiesTable;

/**
 * DBModel\Model\Table\PlatformPropertiesTable Test Case
 */
class PlatformPropertiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\PlatformPropertiesTable
     */
    public $PlatformProperties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.platform_properties',
        'plugin.d_b_model.platforms'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PlatformProperties') ? [] : ['className' => 'DBModel\Model\Table\PlatformPropertiesTable'];
        $this->PlatformProperties = TableRegistry::get('PlatformProperties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlatformProperties);

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
            'platform_id' => 1,
            'name' => 'DEL',
            'value' => 'bin/m'              
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
        $property = $this->PlatformProperties->newEntity($data);
        $this->assertEmpty($property->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['name']);
        unset($data['value']);
        unset($data['platform_id']);
        $delProperties = $this->PlatformProperties->newEntity($data);
        $this->assertEmpty($delProperties->errors());
    }

    /**
     * Test beforeSave method.
     *
     * @return void
     */
    public function testBeforeSave()
    {
        $data = $this->getCorrectData();
        $data['encrypt_data'] = 1;
        $entity = $this->PlatformProperties->newEntity($data);
        $this->PlatformProperties->save($entity);
        $lastProperty = $this->PlatformProperties
                            ->find()
                            ->order(['id' => 'DESC'])
                            ->first();
        $this->assertNotEquals('bin/m', $lastProperty->value);

        // disable encryption
        $data['encrypt_data'] = 0 ;
        $entity = $this->PlatformProperties->newEntity($data);
        $this->PlatformProperties->save($entity);
        $lastProperty = $this->PlatformProperties
                            ->find()
                            ->order(['id' => 'DESC'])
                            ->first();
        $this->assertEquals('bin/m', $lastProperty->value);
    }
}
