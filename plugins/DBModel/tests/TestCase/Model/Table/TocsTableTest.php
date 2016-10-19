<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\TocsTable;

/**
 * DBModel\Model\Table\TocsTable Test Case
 */
class TocsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\TocsTable
     */
    public $Tocs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.tocs',
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
        $config = TableRegistry::exists('Tocs') ? [] : ['className' => 'DBModel\Model\Table\TocsTable'];
        $this->Tocs = TableRegistry::get('Tocs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tocs);

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
            'count' => 2,
            'typ' => 'F',
            'path' => 'test_xml.xml',
            'md5' => '67b132f9af4873e216aa940f780f8249',
            'siz' => 2,
            'offset' => 2          
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
        $toc = $this->Tocs->newEntity($data);
        $result = $this->assertEmpty($toc->errors());
    }

    /**
     * Test validationDefault method. Expecting validation error for empty count.
     *
     * @return void
     */
    public function testValidationDefaultNoCount()
    {   
        $data = $this->getCorrectData();
        $data['count'] = NULL;
        $toc = $this->Tocs->newEntity($data);
        $expectedResult = ['count' => [
                         "_empty" => "This field cannot be left empty", 
                        ]
                    ];
        $this->assertNotEmpty($toc->errors());
        $this->assertEquals($expectedResult, $toc->errors());
    }

    /**
     * Test validationDefault method. Expecting validation error for empty siz.
     *
     * @return void
     */
    public function testValidationDefaultNoSiz()
    {   
        $data = $this->getCorrectData();
        $data['siz'] = NULL;
        $toc = $this->Tocs->newEntity($data);
        $expectedResult = ['siz' => [
                         "_empty" => "This field cannot be left empty", 
                        ]
                    ];
        $this->assertNotEmpty($toc->errors());
        $this->assertEquals($expectedResult, $toc->errors());
    }

    /**
     * Test validationDefault method. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {   
        $data = $this->getCorrectData();
        $data['solid_id'] = NULL;
        $data['typ'] = NULL;
        $data['path'] = NULL;
        $data['md5'] = NULL;
        $toc = $this->Tocs->newEntity($data);
        $this->assertEmpty($toc->errors());
    }

    /**
     * Test locateExistingFile method if threshold param equals nill
     *
     * @return void
     */
    public function testLocateExistingFileNill()
    {
        $params = ['md5' => '80b2157f75e044c8ce67d4e0fd50c24a', 'siz' => 1];
        $threshold = 0;
        $result = $this->Tocs->locateExistingFile($params, $threshold);
        $this->assertEmpty($result);
    }

    /**
     * Test locateExistingFile method if threshold param equals nill
     *
     * @return void
     */
    public function testLocateExistingFile()
    {
        $params = ['md5' => '80b2157f75e044c8ce67d4e0fd50c24a', 'siz' => 1];
        $threshold = 1;
        $result = $this->Tocs->locateExistingFile($params, $threshold);
        $this->assertNotEmpty($result);

        $this->Solids = TableRegistry::get('Solids');
        $solidId = $this->Tocs->find()->select(['solid_id'])->where($params)->first();
        $solid = $this->Solids->get($solidId->solid_id);
        $this->assertEquals($solid->name, $result->artifact_name);
    }
}
