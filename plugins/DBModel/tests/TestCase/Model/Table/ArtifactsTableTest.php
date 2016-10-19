<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\ArtifactsTable;
use DBModel\Model\Table\DeliverablesTable;

/**
 * DBModel\Model\Table\ArtifactsTable Test Case
 */
class ArtifactsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\ArtifactsTable
     */
    public $Artifacts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.artifacts',
        'plugin.d_b_model.artifact_properties',
        'plugin.d_b_model.solids',
        'plugin.d_b_model.sched_properties',
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
        $config = TableRegistry::exists('Artifacts') ? [] : ['className' => 'DBModel\Model\Table\ArtifactsTable'];
        $this->Artifacts = TableRegistry::get('Artifacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Artifacts);
        TableRegistry::remove('Deliverables');

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
            'deliverable_id' => 0,
            'channel_rev_id' => 0,
            'name' => 'New_File_Deploy_Project',
            'status' => 'Queue',
            'gmt_created' => 1473088881,
            'revision' => '0.0.0.[#]',
            'nextrev' => 1,
            'locked' => 0,
            'ref_artifact_id' => 1
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
        $artifact = $this->Artifacts->newEntity($data);
        $this->assertEmpty($artifact->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['name']);
        unset($data['locked']);
        unset($data['ref_artifact_id']);
        unset($data['status']);
        $artifact = $this->Artifacts->newEntity($data);
        $this->assertEmpty($artifact->errors());
    }

    /**
     * Test getHighestParent method if artifact exists
     *
     * @return void
     */
    public function testGetHighestParentArtifactExists()
    {
        $artifactId = 3;
        $existedParent = $this->Artifacts->getHighestParent($artifactId);
        $this->assertLessThanOrEqual($artifactId, $existedParent);
        $this->assertEquals(1, $existedParent); // ID 1 is a parent id of artifact
    }

    /**
     * Test getHighestParent method if artifact not exists
     *
     * @return void
     */
    public function testGetHighestParentArtifactNotExists()
    {
        $notExistedArtifactId = 9999999;
        $notExistedParent = $this->Artifacts->getHighestParent($notExistedArtifactId);
        $this->assertEmpty($notExistedParent);
    }

    /**
     * Test incrementRev method
     *
     * @return void
     */
    public function testIncrementRev()
    {
        $artifactId = 1;
        $data = $this->Artifacts->incrementRev($artifactId);

        $this->assertEquals(2, $this->Artifacts->findById($artifactId)->first()->nextrev);
        $this->assertInstanceOf('Cake\Database\Statement\PDOStatement', $data);
    }

    /**
     * Test getParentStatus method
     *
     * @return void
     */
    public function testGetParentStatus()
    {
        $artifactId = 2;
        $entity = $this->Artifacts->get($artifactId);
        $result = $this->Artifacts->getParentStatus($artifactId);
        $this->assertEquals($entity->status, $result);
    }

    /**
     * Test setArtifactAndDeliverableStatus method
     *
     * @return void
     */
    public function testSetArtifactAndDeliverableStatus()
    {
        $artifactId = 3;
        $result = $this->Artifacts->setArtifactAndDeliverableStatus($artifactId);
        $this->assertNotEmpty($result);
        $artifactEntity = $this->Artifacts->get($artifactId);
        $this->assertEquals($artifactEntity->status, $result);

        $this->Deliverables = TableRegistry::get('Deliverables');
        $deliverableEntity = $this->Deliverables->get($artifactEntity->deliverable_id);
        $this->assertEquals(DeliverablesTable::CONSTRUCT, $deliverableEntity->status);
    }

    /**
     * Test setArtifactStatus method
     *
     * @return void
     */
    public function testSetArtifactStatus()
    {
        $artifactId = 2;
        $status = $this->Artifacts::READY;
        $result = $this->Artifacts->setArtifactStatus($artifactId, $status);
        $this->assertInstanceOf('DBModel\Model\Entity\Artifact', $result);
        $entity = $this->Artifacts->get($artifactId);
        $this->assertEquals($entity->status, $result->status);
    }

    /**
     * Test filterStatuses method if Errror status is present
     *
     * @return void
     */
    public function testFilterStatuses()
    {
        $statusList = [
                $this->Artifacts::READY, 
                $this->Artifacts::ERROR
        ];
        $result = $this->Artifacts->filterStatuses($statusList);
        $this->assertEquals($this->Artifacts::ERROR, $result);
    }

    /**
     * Test filterStatuses method for status of Ready
     *
     * @return void
     */
    public function testFilterStatusesReadyStatus()
    {
        $statusList = [
                $this->Artifacts::READY
        ];
        $result = $this->Artifacts->filterStatuses($statusList);
        $this->assertEquals($this->Artifacts::READY, $result);
    }

    /**
     * Test filterStatuses method for empty array  of statuses
     *
     * @return void
     */
    public function testFilterStatusesEmptyArray()
    {
        $statusList = [];
        $expectedResult = $this->Artifacts::EMPTY;
        $result = $this->Artifacts->filterStatuses($statusList);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Test filterStatuses method with array of params. Expecting CONSTRUCTING status as a result.
     *
     * @return void
     */
    public function testFilterStatusesWithParams()
    {
        $statusList = [
                $this->Artifacts::READY, 
                $this->Artifacts::EMPTY
        ];
        $expectedResult = $this->Artifacts::CONSTRUCTING;
        $result = $this->Artifacts->filterStatuses($statusList);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Test setInitDelivarableStatus method
     *
     * @return void
     */
    public function testSetInitDeliverableStatus()
    {
        $this->Deliverables = TableRegistry::get('Deliverables');
        $deliverableId = 2;
        $resultStatus = $this->Artifacts::READY;
        $result = $this->Artifacts->setInitDelivarableStatus($deliverableId, $resultStatus);
        $this->assertTrue($result);
        $deliverableEntity = $this->Deliverables->get($deliverableId);
        $this->assertEquals(DeliverablesTable::CONSTRUCT, $deliverableEntity->status);
    }


    /**
     * Test setInitDelivarableStatus method for Error status
     *
     * @return void
     */
    public function testSetInitDeliverableStatusError()
    {
        $this->Deliverables = TableRegistry::get('Deliverables');
        $deliverableId = 2;
        $resultStatus = $this->Artifacts::ERROR;
        $result = $this->Artifacts->setInitDelivarableStatus($deliverableId, $resultStatus);
        $this->assertTrue($result);
        $deliverableEntity = $this->Deliverables->get($deliverableId);
        $this->assertEquals($this->Artifacts::ERROR, $deliverableEntity->status);
    }


}
