<?php
namespace App\Test\TestCase\Shell\Task;

use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;
use Cake\Console\Shell;


/**
 * App\Shell\Task\SolidAssetNullTask Test Case
 */
class SolidAssetNullTaskTest extends TestCase
{

    /**
     * ConsoleIo mock
     *
     * @var \Cake\Console\ConsoleIo|\PHPUnit_Framework_MockObject_MockObject
     */
    public $io;

    /**
     * Test subject
     *
     * @var \App\Shell\Task\SolidAssetNullTask
     */
    private $shell;
    private $task;
    public $fixtures = [

        'plugin.d_b_model.solids',
        'plugin.d_b_model.uris',
        'plugin.d_b_model.analyzer_maps',
        'plugin.d_b_model.artifacts',
        'plugin.d_b_model.channel_revs',
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

       $this->shell = new Shell();
       $this->task = $this->shell->Tasks->load('SolidAssetNull');
       $this->task->initialize();

        $solidsConfig = TableRegistry::exists('Solids') ? [] : ['className' => 'DBModel\Model\Table\SolidsTable'];
        $artifactsConfig = TableRegistry::exists('Artifacts') ? [] : ['className' => 'DBModel\Model\Table\ArtifactsTable'];
        $this->Solids = TableRegistry::get('Solids', $solidsConfig);
        $this->Artifacts = TableRegistry::get('Artifacts', $artifactsConfig);
    }

    /**
     * Test get delivery with proper counter and engine id.
     *
     * @return int 
     */
    public function testInstanceWithAnalyzers()
    {         
        $array = array('solidId' => 2);
        $result = $this->task->capabilityMain($array,  array());
        $solid = $this->Solids->findById(2)->first();
        $artifact = $this->Artifacts->findById(1)->first();
        $this->assertEquals('Ready', $solid->status);
        $this->assertEquals('Constructing', $artifact->status);
      
    }

    /**
     * Test get delivery with proper counter and engine id.
     *
     * @return int 
     */
    public function testInstanceWithoutAnalyzers()
    {       
        $array = array('solidId' => 3);  
        $result = $this->task->capabilityMain($array,  array());
        $solid = $this->Solids->findById(3)->first();
        $artifact = $this->Artifacts->findById(2)->first();
        $this->assertEquals('Ready', $solid->status);
        $this->assertEquals('Ready', $artifact->status);
      
    }

    /**
     * Test get delivery with proper counter and engine id.
     *
     * @return int 
     */
    public function testSolidWithNonExistingId()
    {   
        $array = array('solidId' => 4);
        $result = $this->task->capabilityMain($array,  array());
        $this->assertFalse($result);

    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SolidAssetNull);
	unset($this->Solids);
	unset($this->Artifacts);
	unset($this->Engines);

        parent::tearDown();
    }
}
