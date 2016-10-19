<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\UriPropertiesTable;

/**
 * DBModel\Model\Table\UriPropertiesTable Test Case
 */
class UriPropertiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\UriPropertiesTable
     */
    public $UriProperties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.uri_properties',
        'plugin.d_b_model.uris',
        'plugin.d_b_model.uri_depends'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UriProperties') ? [] : ['className' => 'DBModel\Model\Table\UriPropertiesTable'];
        $this->UriProperties = TableRegistry::get('UriProperties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UriProperties);

        parent::tearDown();
    }

    /**
     * getCorrectData method
     *
     * @return array
     */
    private function getCorrectData()
    {
        $data = ['name'=> "home", 
                'value' => 'not_sure_where', 
                'uri_id'=>1, 
                'locked' => 1];
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
        $uriProperty = $this->UriProperties->newEntity($data);
        $this->assertEmpty($uriProperty->errors());
    }

    /**
     * Test validationDefault method. Expecting validation error for empty propery name.
     *
     * @return void
     */
    public function testValidationDefaultNoName()
    {   
        $data = $this->getCorrectData();
        unset($data['name']);
        $uriProperty = $this->UriProperties->newEntity($data);
        $expected = ['name' => [
                        "_required" => "This field is required"]
                    ];
        $this->assertNotEmpty($uriProperty->errors());
        $this->assertEquals($expected, $uriProperty->errors());
    }

    /**
     * Test validationDefault method. Expecting validation error for empty propery value.
     *
     * @return void
     */
    public function testValidationDefaultNoValue()
    {   
        $data = $this->getCorrectData();
        unset($data['value']);
        $uriProperty = $this->UriProperties->newEntity($data);
         $expected = ['value' => [
                        "_required" => "This field is required"]
                    ];
        $this->assertNotEmpty($uriProperty->errors());
        $this->assertEquals($expected, $uriProperty->errors());
    }

    /**
     * Test validationDefault method. Expecting correct result for empty propery locked.
     *
     * @return void
     */
    public function testValidationDefaultNoLock()
    {   
        $data = $this->getCorrectData();
        unset($data['locked']);
        $uriProperty = $this->UriProperties->newEntity($data);
        $this->assertEmpty($uriProperty->errors());
    }
}
