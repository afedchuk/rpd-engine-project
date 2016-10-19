<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\SolidAnalyzerMapsTable;

/**
 * DBModel\Model\Table\SolidAnalyzerMapsTable Test Case
 */
class SolidAnalyzerMapsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\SolidAnalyzerMapsTable
     */
    public $SolidAnalyzerMaps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.solid_analyzer_maps',
        'plugin.d_b_model.solids',
        'plugin.d_b_model.analyzers',
        'plugin.d_b_model.modules',
        'plugin.d_b_model.analyzer_maps',
        'plugin.d_b_model.uris',
        'plugin.d_b_model.analyzer_properties'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SolidAnalyzerMaps') ? [] : ['className' => 'DBModel\Model\Table\SolidAnalyzerMapsTable'];
        $this->SolidAnalyzerMaps = TableRegistry::get('SolidAnalyzerMaps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SolidAnalyzerMaps);

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
            'analyzer_id' => 2,
            'sequence' => 1       
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
        $solidAnalyzerMap = $this->SolidAnalyzerMaps->newEntity($data);
        $this->assertEmpty($solidAnalyzerMap->errors());
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
        unset($data['analyzer_id']);
        unset($data['sequence']);
        $solidAnalyzerMap = $this->SolidAnalyzerMaps->newEntity($data);
        $this->assertEmpty($solidAnalyzerMap->errors());
    }

    /**
     * Test analyzeContent method.
     *
     * @return void
     */ 
    public function testAnalyzeContant()
    {
        $this->Solids = TableRegistry::get('Solids', ['className' => 'DBModel\Model\Table\SolidsTable']);
        $solid = $this->Solids->find()->first()->toArray();
        $artifactId = 1;
        $result = $this->SolidAnalyzerMaps->analyzeContent($solid, $artifactId);
        $this->assertNotEmpty($result);
    }

    /**
     * Test copyMap method.
     *
     * @return void
     */ 
    public function testCopyMap()
    {
        $fromSolidId = 1;
        $toSolidId = 2;
        $notExistingRecord = $this->SolidAnalyzerMaps->find()->where(['solid_id' => $toSolidId])->toArray();
        $this->assertEmpty($notExistingRecord);
        $result = $this->SolidAnalyzerMaps->copyMap($fromSolidId, $toSolidId);
        $this->assertTrue($result);
        $newRecord = $this->SolidAnalyzerMaps->find()->where(['solid_id' => $toSolidId])->toArray();
        $this->assertNotEmpty($newRecord);
    }

    /**
     * Test copyMap method for not existing solid ID.
     *
     * @return void
     */ 
    public function testCopyMapNoSolidId()
    {
        $fromSolidId = 1000;
        $toSolidId = 2;
        $result = $this->SolidAnalyzerMaps->copyMap($fromSolidId, $toSolidId);
        $this->assertFalse($result);
    }

    /**
     * Test addSolidToAnalyzer method.
     *
     * @return void
     */
    public function testAddSolidToAnalyzer()
    {
        $this->Solids = TableRegistry::get('Solids', ['className' => 'DBModel\Model\Table\SolidsTable']);
        $lastId = $this->SolidAnalyzerMaps->getInsertID();
        $solidId = 1;
        $solid = $this->Solids->get($solidId, ['contain'=>['Uris.AnalyzerMaps'] ]);
        $arrayCount = count($solid->uri->analyzer_maps); //in order to know quantity of inserted records
        $result = $this->SolidAnalyzerMaps->addSolidToAnalyzer($solidId);
        $this->assertTrue($result);
        $newLastId = $this->SolidAnalyzerMaps->getInsertID();
        $this->assertEquals($lastId + $arrayCount, $newLastId);
    }
}
