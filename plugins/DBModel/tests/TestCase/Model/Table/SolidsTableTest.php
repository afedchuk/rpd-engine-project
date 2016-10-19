<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\SolidsTable;

/**
 * DBModel\Model\Table\SolidsTable Test Case
 */
class SolidsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\SolidsTable
     */
    public $Solids;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.solids',
        'plugin.d_b_model.uris',
        'plugin.d_b_model.artifacts',
        'plugin.d_b_model.channel_revs',
        'plugin.d_b_model.deliverables',
        'plugin.d_b_model.solid_depends',
        'plugin.d_b_model.analyzer_maps',
        'plugin.d_b_model.prefs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Solids') ? [] : ['className' => 'DBModel\Model\Table\SolidsTable'];
        $this->Solids = TableRegistry::get('Solids', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Solids);

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
            'uri_require' => 0,
            'remote_location' => '',
            'content' => '',
            'meta' => '',
            'stamp' => '0',
            'product_id' => 0,
            'deliverable_id' => 0,
            'engine_id' => 0,
            'uri_id' => 0,
            'solid_id' => 0,
            'active' => 'y',
            'splode' => 'n',
            'md5' => '',
            'toc' => '',
            'delivery_id' => 1,
            'ref_artifact_id' => 1,
            'reference_id' => 0,
            'analyz' => 'y',
            'gmt_fetched' => 1471251672,
            'status' => 'Ready',
            'pct' => 0,
            'siz' => 0,
            'module_name' => 'artifact_reference',
            'bridge_id' => 1,
            'store_uri' => 'db://base64/57b17b93-9cc8-4ce2-80d9-08400a802413',
            'location' => 'reference://asset/Sample_File_Deploy_Project',
            'sequence' => 1,
            'name' => 'Sample_File_Deploy_Project',
            'artifact_id' => 1
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
        $solid = $this->Solids->newEntity($data);
        $this->assertEmpty($solid->errors());
    }

    /**
     * Test validationDefault method. Expecting validation error for empty status.
     *
     * @return void
     */
    public function testValidationDefaultNoStatus()
    {   
        $data = $this->getCorrectData();
        $data['status'] = NULL;
        $zoneProperty = $this->Solids->newEntity($data);
        $expectedResult = ['status' => [
                         "_empty" => "This field cannot be left empty", 
                        ]
                    ];
        $this->assertNotEmpty($zoneProperty->errors());
        $this->assertEquals($expectedResult, $zoneProperty->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['locked']);
        unset($data['ref_artifact_id']);
        unset($data['deliverable_id']);
        unset($data['content']);
        unset($data['stamp']);
        $artifact = $this->Solids->newEntity($data);
        $this->assertEmpty($artifact->errors());
    }

    /**
     * Test getSolidsRecursively method for one field
     *
     * @return void
     */
    public function testGetSolidsRecursivelyOneField()
    {
        $solidId = 1;
        $artifactId = 1;
        $field = 'name';
        $solid = $this->Solids
                    ->get($solidId);
        $oneFieldResult = $this->Solids->getSolidsRecursively($artifactId, $field, [$solid], true);
        $this->assertNotEmpty($oneFieldResult);
        $this->assertEquals($oneFieldResult[$solidId], $solid[$field]);
    }

    /**
     * Test getSolidsRecursively method for array of fields
     *
     * @return void
     */
    public function testGetSolidsRecursivelyFieldsArray()
    {
        $solidId = 1;
        $artifactId = 1;
        $fields = ['id', 'name', 'location'];
        $solid = $this->Solids
                    ->get($solidId);
        // values of fields
        $solidFields = $this->Solids
                            ->find()
                            ->select($fields)
                            ->where(['id' => $solidId])
                            ->first();
        $fieldsArrayResult = $this->Solids->getSolidsRecursively($artifactId, $fields, [$solid], true);
        $this->assertNotEmpty($fieldsArrayResult);
        foreach ($fields as $field) {
            $this->assertEquals($fieldsArrayResult[$solidId][$field], $solidFields->$field);
        }
    }

    /**
     * Test consistencyHook method
     *
     * @return void
     */
    public function testConsistencyHook()
    {
        $solidId = 8;
        $solidEntity = $this->Solids->get($solidId);
        $result = $this->Solids->consistencyHook($solidEntity);
        $this->assertNull($result);
    }

    /**
     * Test filterArtifactSolid method for one field
     *
     * @return void
     */
    public function testFilterArtifactSolidOneField()
    {
        $solidId = 1;
        $field = 'name';
        $solid = $this->Solids
                    ->get($solidId);
        // method execution result
        $oneFieldResult = $this->Solids->filterArtifactSolid($field, $solid); 
        $this->assertNotEmpty($oneFieldResult);
        $this->assertArrayHasKey($solidId, $oneFieldResult);
        $this->assertEquals($oneFieldResult[$solidId], $solid[$field]);
    }

    /**
     * Test filterArtifactSolid method for array of fields
     *
     * @return void
     */
    public function testFilterArtifactSolidFieldsArray()
    {
        $solidId = 1;
        $fieldsArray = ['name', 'location'];
        $solid = $this->Solids
                    ->get($solidId);
        // values of fields
        $solidFields = $this->Solids
                            ->find()
                            ->select($fieldsArray)
                            ->where(['id' => $solidId])
                            ->first();
        // method execution result
        $fieldsArrayResult = $this->Solids->filterArtifactSolid($fieldsArray, $solid); 
        $this->assertNotEmpty($fieldsArrayResult);
        $this->assertArrayHasKey($solidId, $fieldsArrayResult);
        foreach ($fieldsArray as $field) {
            $this->assertEquals($fieldsArrayResult[$solidId][$field], $solidFields->$field);
        }
    }
    
    /**
     * Test filterArtifactSolid method for array of fields
     *
     * @return void
     */
    public function testPopulateWithRemoteReference()
    {
         $solid = $this->Solids->populateSolid(1);
         $this->assertEquals($this->Solids::FETCHING, $solid->status);
    }

    /**
     * Test setSolidStatus method
     *
     * @return void
     */
    public function testSetSolidStatus()
    {
        $solidId = 7;
        $pct = 1;
        $status = $this->Solids::READY;
        $result = $this->Solids->setSolidStatus($solidId, $pct, $status);
        $entity = $this->Solids->get($solidId);
        $this->assertEquals($status, $entity->status);
        $this->assertEquals($pct, $entity->pct);
        $this->assertTrue($result);
    }

    /**
     * Test setSolidStatus method if status equals 'Error'
     *
     * @return void
     */
    public function testSetSolidStatusErrorStatus()
    {
        $solidId = 7;
        $pct = 1;
        $status = $this->Solids::ERROR;
        $entityBeforeMethodExecution = $this->Solids->get($solidId);
        $result = $this->Solids->setSolidStatus($solidId, $pct, $status);
        $entityAfterMethodExecution = $this->Solids->get($solidId);
        $this->assertNotEquals($entityBeforeMethodExecution->analyz, $entityAfterMethodExecution->analyz);
        $this->assertEquals($entityAfterMethodExecution->analyz, 'n');
        $this->assertTrue($result);
    }

    /**
     * Test setSolidStatus method if solid ID equals 0
     *
     * @return void
     */
    public function testSetSolidStatusIncorrectID()
    {
        $solidId = 0;
        $pct = 1;
        $status = $this->Solids::READY;
        $result = $this->Solids->setSolidStatus($solidId, $pct, $status);
        $this->assertFalse($result);
    }

    /**
     * Test getRecursiveSolidById method
     *
     * @return void
     */
    public function testGetRecursiveSolidById()
    {
        $solidId = 1;
        $result = $this->Solids->getRecursiveSolidById($solidId);
        $this->assertNotEmpty($result);
        $this->assertNotEmpty($result['uri']);
        $this->assertNotEmpty($result['solid_depends']);
        $this->assertNotEmpty($result['artifact']);
    }

    /**
     * Test populateMasterSlaveSolid method
     *
     * @return void
     */
    public function testPopulateMasterSlaveSolid()
    {
        $data = [
            'uri_require' => 1,
            'remote_location' => '',
            'content' => '',
            'meta' => '',
            'stamp' => '0',
            'product_id' => 1,
            'deliverable_id' => 1,
            'engine_id' => 1,
            'uri_id' => 1,
            'solid_id' => 1,
            'active' => 'y',
            'splode' => 'n',
            'md5' => '',
            'toc' => '',
            'delivery_id' => 1,
            'ref_artifact_id' => 1,
            'reference_id' => 1,
            'analyz' => 'y',
            'gmt_fetched' => 1471251154,
            'status' => 'Ready',
            'pct' => 1,
            'siz' => 1,
            'module_name' => 'artifact_reference',
            'bridge_id' => 1,
            'store_uri' => 'db://base64/57b17b93-c544-42e3-8189-08400a802413',
            'location' => 'sample_file_new_location',
            'sequence' => 1,
            'name' => 'Sample File',
            'artifact_id' => 1
        ]; 
        $resultValue = $this->Solids->populateMasterSlaveSolid($data);
        $lastId = $this->Solids->getInsertID();
        $entity = $this->Solids->get($lastId);
        $this->assertEquals($resultValue, $entity->reference_id);
    }

    /**
     * Test updateSolid method
     *
     * @return void
     */
    public function testUpdateSolid()
    {
        $solidId = 1;
        $entity = $this->Solids->get($solidId, ['contain'=>'Uris']);
        $result = $this->Solids->updateSolid($solidId);
        $this->assertNotEquals($entity->analyz, $result->analyz);
        $this->assertEquals('n', $result->analyz);
        $this->assertNotEquals($entity->module_name, $result->module_name);
        $this->assertEquals('asset_action', $result->module_name);
        $this->assertNotEquals($entity->bridge_id, $result->bridge_id);
        $this->assertEquals($result->uri->bridge_id, $result->bridge_id);
    }

    /**
     * Test hasInstanceSolidsAnyAnalyzers method
     *
     * @return void
     */
    public function testHasInstanceSolidsAnyAnalyzers()
    {
        $artifactId = 1;
        $result = $this->Solids->hasInstanceSolidsAnyAnalyzers($artifactId);
        $this->assertTrue($result);
    }

    /**
     * Test hasInstanceSolidsAnyAnalyzers method for not existing artifact
     *
     * @return void
     */
    public function testHasInstanceSolidsAnyAnalyzersNoArtifactId()
    {
        $artifactId = 9999999;
        $result = $this->Solids->hasInstanceSolidsAnyAnalyzers($artifactId);
        $this->assertFalse($result);
    }
}
