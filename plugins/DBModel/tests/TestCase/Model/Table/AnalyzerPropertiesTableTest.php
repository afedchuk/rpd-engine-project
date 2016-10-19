<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\AnalyzerPropertiesTable;

/**
 * DBModel\Model\Table\AnalyzerPropertiesTable Test Case
 */
class AnalyzerPropertiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\AnalyzerPropertiesTable
     */
    public $AnalyzerProperties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.analyzer_properties',
        'plugin.d_b_model.analyzers',
        'plugin.d_b_model.modules',
        'plugin.d_b_model.analyzer_maps',
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
        $config = TableRegistry::exists('AnalyzerProperties') ? [] : ['className' => 'DBModel\Model\Table\AnalyzerPropertiesTable'];
        $this->AnalyzerProperties = TableRegistry::get('AnalyzerProperties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AnalyzerProperties);

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
