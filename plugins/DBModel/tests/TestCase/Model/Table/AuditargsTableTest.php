<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\AuditargsTable;

/**
 * DBModel\Model\Table\AuditargsTable Test Case
 */
class AuditargsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\AuditargsTable
     */
    public $Auditargs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.auditargs',
        'plugin.d_b_model.oddits',
        'plugin.d_b_model.events',
        'plugin.d_b_model.usrs',
        'plugin.d_b_model.api'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Auditargs') ? [] : ['className' => 'DBModel\Model\Table\AuditargsTable'];
        $this->Auditargs = TableRegistry::get('Auditargs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Auditargs);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
