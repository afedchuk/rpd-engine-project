<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\LochesTable;

/**
 * DBModel\Model\Table\LochesTable Test Case
 */
class LochesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\LochesTable
     */
    public $Loches;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.loches'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Loches') ? [] : ['className' => 'DBModel\Model\Table\LochesTable'];
        $this->Loches = TableRegistry::get('Loches', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Loches);

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
            'owner' => '157d66559c386a8.03945530',
            'name' => 'tasks',
            'gmt_expires' => 1473668444,
            'id' => 10000
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
        $lock = $this->Loches->newEntity($data);
        $this->assertEmpty($lock->errors());
    }
    /**
     * Test validationDefault method. Validate if duplicatd entry exists.
     *
     * @return void
     */
    public function testValidationDuplicate()
    {
        $data = $this->getCorrectData();
        $data['id'] = 21;
        $lock = $this->Loches->newEntity($data);
        $this->assertEmpty($lock->errors());
        $data['id'] = 23;
        $lock = $this->Loches->newEntity($data);
        $this->expectException('PDOException');
        $this->expectExceptionCode('23505');
        $this->expectExceptionMessage('duplicate key value violates unique constraint');
        $this->Loches->save($lock);
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['owner']);
        unset($data['name']);
        unset($data['gmt_expires']);
        $lock = $this->Loches->newEntity($data);
        $this->assertEmpty($lock->errors());
    }

    /**
     * Test getLock method
     *
     * @return void
     */
    public function testGetLock()
    {   
        $name = 'new_lock';
        $owner = '127cffff6282202.52364259';
        $lock = $this->Loches->getLock($name, $owner);
        $this->assertTrue($lock);

        //for different name
        $diffName = 'differentName';
        $differentNameLock = $this->Loches->getLock($diffName, $owner);
        $this->assertTrue($differentNameLock);
    }
    
	/**
     * Test getLock method
     *
     * @return void
     */
    public function testGetLockDuplicate()
    {   
        $lock = $this->Loches->getLock('analyzers', '557cffff6286602.47019783', 30, 1, 0);
        $differentNameLock = $this->Loches->getLock('analyzers', '557gffff6286602.47019783', 3, 1, 0);
        $this->assertTrue($lock);
        $this->assertFalse($differentNameLock);
    }

    public function testGetLockDuplicateIdentical()
    {   
        $lock = $this->Loches->getLock('solids', '557cffff6286602', 30, 1, 2);
        $differentNameLock = $this->Loches->getLock('solids', '557cffff6286602', 3, 1, 2);
        $this->assertTrue($lock);
        $this->assertTrue($differentNameLock);
    }

    public function testGetLockDuplicateLoop()
    {   
        $count = 100;
        while($count > 0){
            $lock = $this->Loches->getLock('solids', '557cffff6286602'.$count, 3, 1, 0);
            $count === 100 ? $this->assertTrue($lock) : $this->assertFalse($lock);
            $count --;
        }
    }

    /**
     * Test identifyUpdate method
     *
     * @return void
     */
    public function testIdentifyUpdate()
    {
        $this->assertEmpty($this->Loches->identifyUpdate()); //check if identifyUpdate method is executable because it doesn't return anything
    }

    /**
     * Test put method
     *
     * @return void
     */
    public function testPut()
    {
        $name = 'analyzers';
        $owner = '557cffff6286602.47019783';
        $put = $this->Loches->put($name, $owner);
        $this->assertTrue($put);

        //without owner
        $lock = $this->Loches->getLock($name, '557cffff6286602', 30, 1, 0);
        $put = $this->Loches->put($name);
        $this->assertTrue($put);

        // Non existsing record
        $put = $this->Loches->put('ababagalamaga', 'asar1231251asads');
        $this->assertFalse($put);

        //without params
        $this->setExpectedException('TypeError');
        $this->Loches->put();
    }
}
