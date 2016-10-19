<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\AnalyzerMapsTable;

/**
 * DBModel\Model\Table\AnalyzerMapsTable Test Case
 */
class AnalyzerMapsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\AnalyzerMapsTable
     */
    public $AnalyzerMaps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.analyzer_maps',
        'plugin.d_b_model.uris',
        'plugin.d_b_model.analyzers',
        'plugin.d_b_model.modules',
        'plugin.d_b_model.analyzer_properties',
        'plugin.d_b_model.solid_analyzer_maps'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AnalyzerMaps') ? [] : ['className' => 'DBModel\Model\Table\AnalyzerMapsTable'];
        $this->AnalyzerMaps = TableRegistry::get('AnalyzerMaps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AnalyzerMaps);

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
