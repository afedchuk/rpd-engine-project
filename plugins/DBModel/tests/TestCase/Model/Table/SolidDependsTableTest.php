<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\SolidDependsTable;

/**
 * DBModel\Model\Table\SolidDependsTable Test Case
 */
class SolidDependsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\SolidDependsTable
     */
    public $SolidDepends;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.solid_depends',
        'plugin.d_b_model.solids'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SolidDepends') ? [] : ['className' => 'DBModel\Model\Table\SolidDependsTable'];
        $this->SolidDepends = TableRegistry::get('SolidDepends', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SolidDepends);

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
            'solid_id' => 2,
            'solid_depend_id' => 1,
            'type' => 'pass',
            'scope' => 1,
            'count' => 1
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
        $solidDep = $this->SolidDepends->newEntity($data);
        $this->assertEmpty($solidDep->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['solid_id']);
        unset($data['solid_depend_id']);
        unset($data['type']);
        unset($data['scope']);
        unset($data['count']);
        $solid = $this->SolidDepends->newEntity($data);
        $this->assertEmpty($solid->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testPopulateMasterSlaveSolidDepend()
    {
        $slaveId = 1;
        $solidId = 1;
        $result = $this->SolidDepends->populateMasterSlaveSolidDepend($slaveId, $solidId);
        $data = $this
                    ->SolidDepends
                    ->find('list', ['keyField' => 'id', 'valueField' => 'solid_id'])
                    ->where(['solid_depend_id' => $solidId])
                    ->toArray();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $record = $this->SolidDepends->find()->where(['solid_id' => $value, 'solid_depend_id' => $slaveId])->toArray();
                $this->assertNotEmpty($record);
            }
        }
        $this->assertTrue($result);
    }
}
