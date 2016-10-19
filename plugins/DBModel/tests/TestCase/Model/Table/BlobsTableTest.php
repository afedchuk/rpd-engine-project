<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\BlobsTable;

/**
 * DBModel\Model\Table\BlobsTable Test Case
 */
class BlobsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\BlobsTable
     */
    public $Blobs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.blobs',
        'plugin.d_b_model.solids',
        'plugin.d_b_model.deliverables',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Blobs') ? [] : ['className' => 'DBModel\Model\Table\BlobsTable'];
        $this->Blobs = TableRegistry::get('Blobs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Blobs);

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
