<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\BridgePropertiesTable;

/**
 * DBModel\Model\Table\BridgePropertiesTable Test Case
 */
class BridgePropertiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\BridgePropertiesTable
     */
    public $BridgeProperties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.bridge_properties',
        'plugin.d_b_model.bridges'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BridgeProperties') ? [] : ['className' => 'DBModel\Model\Table\BridgePropertiesTable'];
        $this->BridgeProperties = TableRegistry::get('BridgeProperties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BridgeProperties);

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
            'name' => 'test_server',
            'value' => 'server',
            'bridge_id' => 1
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
        $bridgeProperty = $this->BridgeProperties->newEntity($data);
        $this->assertEmpty($bridgeProperty->errors());
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
        $bridgeProperty = $this->BridgeProperties->newEntity($data);
        $expected = ['name' => [
                        "_required" => "This field is required"]
                    ];
        $this->assertNotEmpty($bridgeProperty->errors());
        $this->assertEquals($expected, $bridgeProperty->errors());
    }
}
