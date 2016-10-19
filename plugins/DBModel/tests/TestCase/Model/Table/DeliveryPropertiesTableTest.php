<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\DeliveryPropertiesTable;

/**
 * DBModel\Model\Table\DeliveryPropertiesTable Test Case
 */
class DeliveryPropertiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\DeliveryPropertiesTable
     */
    public $DeliveryProperties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.delivery_properties',
        'plugin.d_b_model.deliveries',       
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DeliveryProperties') ? [] : ['className' => 'DBModel\Model\Table\DeliveryPropertiesTable'];
        $this->DeliveryProperties = TableRegistry::get('DeliveryProperties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DeliveryProperties);

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
            'delivery_id' => 1,
            'name' => 'pack_property',
            'value' => 'pack',
            'artifact_uri_id' => 1
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
        $delProperties = $this->DeliveryProperties->newEntity($data);
        $this->assertEmpty($delProperties->errors());
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
        unset($data['delivery_id']);
        unset($data['artifact_uri_id']);
        $delProperties = $this->DeliveryProperties->newEntity($data);
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
        $entity = $this->DeliveryProperties->newEntity($data);
        $this->DeliveryProperties->save($entity);
        $lastProperty = $this->DeliveryProperties
                            ->find()
                            ->order(['id' => 'DESC'])
                            ->first();
        $this->assertNotEquals('pack', $lastProperty->value);

        // disable encryption
        $data['encrypt_data'] = 0;
        $entity = $this->DeliveryProperties->newEntity($data);
        $this->DeliveryProperties->save($entity);
        $lastProperty = $this->DeliveryProperties
                            ->find()
                            ->order(['id' => 'DESC'])
                            ->first();
        $this->assertEquals('pack', $lastProperty->value);
    }
}
