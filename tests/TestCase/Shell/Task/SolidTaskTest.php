<?php
namespace App\Test\TestCase\Shell\Task;

use App\Shell\Task\SolidTask;
use App\Shell\Task\QueueTask;
use Cake\Console\Shell;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Shell\Task\SolidTask Test Case
 */
class SolidTaskTest extends TestCase
{

    public $fixtures = [

        'plugin.d_b_model.solids',
        'plugin.d_b_model.uris',
        'plugin.d_b_model.bridges',
        'plugin.d_b_model.zones',
        'plugin.d_b_model.engines',
        'plugin.d_b_model.engine_hosts',
        'plugin.d_b_model.artifacts',
        'plugin.d_b_model.channel_revs',
        'plugin.d_b_model.deliverables',
	    'plugin.d_b_model.loches'


    ];
    /**
    * Call protected/private method of a class.
    *
    * @param object &$object    Instantiated object that we will run method on.
    * @param string $methodName Method name to call
    * @param array  $parameters Array of parameters to pass into method.
    *
    * @return mixed Method return.
    */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
    $reflection = new \ReflectionClass(get_class($object));
    $method = $reflection->getMethod($methodName);
    $method->setAccessible(true);

    return $method->invokeArgs($object, $parameters);
    }

    /**
     * ConsoleIo mock
     *
     * @var \Cake\Console\ConsoleIo|\PHPUnit_Framework_MockObject_MockObject
     */
    public $io;

    /**
     * Test subject
     *
     * @var \App\Shell\Task\SolidTask
     */
    public $Solid;
    private $shell;
    private $task;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
       $this->shell = new Shell();
       $this->queue = new QueueTask();
       $this->task = $this->shell->Tasks->load('Solid');
       $this->task->initialize();
       $config = TableRegistry::exists('Solids') ? [] : ['className' => 'DBModel\Model\Table\SolidsTable'];
       $artifactConfig = TableRegistry::exists('Artifacts') ? [] : ['className' => 'DBModel\Model\Table\ArtifactsTable'];
       $deliverablesConfig = TableRegistry::exists('Artifacts') ? [] : ['className' => 'DBModel\Model\Table\DeliverablesTable'];
       $enginesConfig = TableRegistry::exists('Artifacts') ? [] : ['className' => 'DBModel\Model\Table\EnginesTable'];
       $bridgesConfig = TableRegistry::exists('Bridges') ? [] : ['className' => 'DBModel\Model\Table\BridgesTable'];   
       $this->Solids = TableRegistry::get('Solids', $config);
       $this->Artifacts = TableRegistry::get('Artifacts', $artifactConfig);
       $this->Deliverables = TableRegistry::get('Deliverables', $deliverablesConfig);
       //$this->Engines = TableRegistry::get('Engines', $enginesConfig);
       $this->Bridges = TableRegistry::get('Bridges', $bridgesConfig);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Solid);

        parent::tearDown();
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testMain()
    {
        set('engineId', 123456);
        $result = $this->task->main();
    }

    /**
     * Test populate method. No Zone.
     *
     * @return void
     */
    public function testPopulate()
    {
        set('engineId', 123456);
        $result = $this->invokeMethod($this->task, 'populate', [6]);
        $this->assertTrue($result); 
        $result = $this->Solids->get(6);
        $this->assertEquals($result->status, 'Fetching');
        $this->assertEquals($result->engine_id, 123456);
        $result = $this->Artifacts->get($result->artifact_id);
        $this->assertEquals($result->status, 'Constructing');
        $result = $this->Deliverables->get($result->deliverable_id);
        $this->assertEquals($result->status, 'Construct');
        
    }

    /**
     * Test populate method. Bridge assigned to Zone.
     *
     * @return void
     */
    public function testPopulateBridgeWithZone()
    {
        set('engineId', 123456);
        $this->Solids->deleteAll(['id IN' => [1,2,3,4,6]]);
        $result = $this->task->main();
        $this->assertFalse($result);
    }

    /**
     * Test populateInMyZone method. Engine has a Zone and Bridge in the same zone
     *
     * @return void
     */
    public function testPopulateInMyZone()
    {
        $this->Solids->deleteAll(['id IN' => [1,2,3,4,6]]);
        $engine = $this->Engines->findByHostname('WithZones')->first();
        set('engineId', $engine->id);
        $result = $this->task->main();
        $out = ['params' => ['solidId' => 5], 'module' => 'asset_file' ,  'prefix' => 'Solid'];
        $this->assertEquals($result , $out);
        $result = $this->Solids->get(5);
        $this->assertEquals($result->status, 'Fetching');
        $this->assertEquals($result->engine_id, $engine->id);
        $result = $this->Artifacts->get($result->artifact_id);
        $this->assertEquals($result->status, 'Constructing');
        $result = $this->Deliverables->get($result->deliverable_id);
        $this->assertEquals($result->status, 'Construct');
        
    }

    /**
     * Test populateInMyZone method. Engine has a Zone and Bridge in the different zone
     *
     * @return void
     */
    public function testPopulateInMyZoneEnigeZone1BridgeZone2()
    {
        // $engine = $this->Engines->findByHostname('WithZones')->first();
        // set('engineId', $engine->id);
        // $validServersList = $this->Bridges->getZoneServerList(2);
        // $validServersList += [0];
        // $result = $this->invokeMethod($this->task, 'populateInMyZone', [$validServersList,4]);
        // $this->assertFalse($result);        
    }

    /**
     * Test populateInMyZone method. Engine has a Zone and Bridge no zone
     *
     * @return void
     */
    public function testPopulateInMyZoneEnigeZone1BridgeNoZone()
    {
        // $engine = $this->Engines->findByHostname('WithZones')->first();
        // set('engineId', $engine->id);
        // $validServersList = $this->Bridges->getZoneServerList(2);
        // $validServersList += [0];
        // $result = $this->invokeMethod($this->task, 'populateInMyZone', [$validServersList,6]);
        // $this->assertFalse($result);        
    }
}
