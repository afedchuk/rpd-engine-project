<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\ApiTable;

/**
 * DBModel\Model\Table\ApiTable Test Case
 */
class ApiTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\ApiTable
     */
    public $Api;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.api',
        'plugin.d_b_model.events',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Api') ? [] : ['className' => 'DBModel\Model\Table\ApiTable'];
        $this->Api = TableRegistry::get('Api', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Api);

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
            'toc' => 'toc',
            'groops' => 'group',
            'event_id' => 1,
            'gmt_expires' => 1476290256,
            'token' => '57d6da30-aef0-4601-88e5-1940ac166b3f',
            'username' => 'phurnace'
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
        $api = $this->Api->newEntity($data);
        $this->assertEmpty($api->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['username']);
        unset($data['token']);
        unset($data['gmt_expires']);
        unset($data['event_id']);
        unset($data['groops']);
        unset($data['toc']);
        $api = $this->Api->newEntity($data);
        $this->assertEmpty($api->errors());
    }

    public function testConsistencyHook()
    {
        $data = $this->getCorrectData();
        $api = $this->Api->newEntity($data);
        $entity = $this->Api->save($api);
        $result = $this->Api->consistencyHook($entity);
        $this->expectException('Cake\Datasource\Exception\RecordNotFoundException');
        $this->expectExceptionCode('404');
        $this->expectExceptionMessage('Record not found in table "' . $this->Api->table() . '"');
        $record = $this->Api->get($entity->id);
    }
}
