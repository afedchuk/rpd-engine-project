<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\UriDependsTable;

/**
 * DBModel\Model\Table\UriDependsTable Test Case
 */
class UriDependsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\UriDependsTable
     */
    public $UriDepends;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.uri_depends',
        'plugin.d_b_model.uris',
        'plugin.d_b_model.uri_properties'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UriDepends') ? [] : ['className' => 'DBModel\Model\Table\UriDependsTable'];
        $this->UriDepends = TableRegistry::get('UriDepends', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UriDepends);

        parent::tearDown();
    }

    /**
     * getCorrectData method
     *
     * @return array
     */
    private function getCorrectData()
    {
        $data = ['uri_id'=> 1, 
                'uri_depend_id' => 2, 
                'type'=>'pass', 
                'scope' => 1];
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
        $uriDepend = $this->UriDepends->newEntity($data);
        $this->assertEmpty($uriDepend->errors());
    }

    /**
     * Test validationDefault method. Expecting validation error for empty propery name.
     *
     * @return void
     */
    public function testValidationDefaultNoUriId()
    {   
        $data = $this->getCorrectData();
        unset($data['uri_id']);
        $uriDepend = $this->UriDepends->newEntity($data);
        $expected = ['uri_id' => [
                        "_required" => "This field is required"]
                    ];
        $this->assertNotEmpty($uriDepend->errors());
        $this->assertEquals($expected, $uriDepend->errors());
    }

    /**
     * Test validationDefault method. Expecting validation error for empty propery value.
     *
     * @return void
     */
    public function testValidationDefaultNoUriDependId()
    {   
        $data = $this->getCorrectData();
        unset($data['uri_depend_id']);
        $uriDepend = $this->UriDepends->newEntity($data);
         $expected = ['uri_depend_id' => [
                        "_required" => "This field is required"]
                    ];
        $this->assertNotEmpty($uriDepend->errors());
        $this->assertEquals($expected, $uriDepend->errors());
    }

    /**
     * Test validationDefault method. Expecting correct result for empty propery locked.
     *
     * @return void
     */
    public function testValidationDefaultNoType()
    {   
        $data = $this->getCorrectData();
        unset($data['type']);
        $uriDepend = $this->UriDepends->newEntity($data);
         $expected = ['type' => [
                        "_required" => "This field is required"]
                    ];
        $this->assertNotEmpty($uriDepend->errors());
        $this->assertEquals($expected, $uriDepend->errors());
    }
}
