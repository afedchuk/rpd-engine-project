<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\OdditsTable;

/**
 * DBModel\Model\Table\OdditsTable Test Case
 */
class OdditsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\OdditsTable
     */
    public $Oddits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.oddits',
        'plugin.d_b_model.events',
        'plugin.d_b_model.auditargs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        TableRegistry::remove('Oddits');
        $config = TableRegistry::exists('Oddits') ? [] : ['className' => 'DBModel\Model\Table\OdditsTable'];
        $this->Oddits = TableRegistry::get('Oddits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Oddits);

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
            'event_id' => 1,
            'gmt_created' => 1471530507,
            'message' => 'Completed Installation of Report [name].'
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
        $oddit = $this->Oddits->newEntity($data);
        $this->assertEmpty($oddit->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['event_id']);
        unset($data['gmt_created']);
        unset($data['message']);
        $oddit = $this->Oddits->newEntity($data);
        $this->assertEmpty($oddit->errors());
    }

    /**
     * Test putAudit method
     *
     * @return void
     */
    public function testPutAudit()
    {
        $eventId = 1;
        $message = 'Completed Installation of Report [name].';
        $result = $this->Oddits->putAudit($eventId, $message);
        $this->assertTrue($result);
    }

    /**
     * Test putAudit method with args
     *
     * @return void
     */
    public function testPutAuditWitArgs()
    {
        $eventId = 1;
        $message = 'Installing new Library Activity.';
        $args = [
            '[solid_name]' => 'Sample_File_Deploy', 
            '[artifact_id]' => 1
        ];
        $result = $this->Oddits->putAudit($eventId, $message, $args);
        $this->assertTrue($result);
        $lastID = $this->Oddits->getInsertID();
        $this->Auditargs = TableRegistry::get('Auditargs', ['className' => 'DBModel\Model\Table\AuditargsTable']);
        $entity = $this->Auditargs->get($lastID);
        $this->assertNotEmpty($entity);
        $this->assertInternalType('object', $entity);
        $this->assertInstanceOf('DBModel\Model\Entity\Auditarg', $entity);
    }
}
