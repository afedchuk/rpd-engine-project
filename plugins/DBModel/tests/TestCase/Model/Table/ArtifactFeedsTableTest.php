<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\ArtifactFeedsTable;

/**
 * DBModel\Model\Table\ArtifactFeedsTable Test Case
 */
class ArtifactFeedsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\ArtifactFeedsTable
     */
    public $ArtifactFeeds;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.artifact_feeds',
        'plugin.d_b_model.artifacts',
        'plugin.d_b_model.channel_revs',
        'plugin.d_b_model.channels',
        'plugin.d_b_model.channel_types',
        'plugin.d_b_model.processes',
        'plugin.d_b_model.engines',
        'plugin.d_b_model.deliveries',
        'plugin.d_b_model.solids',
        'plugin.d_b_model.tasks',
        'plugin.d_b_model.engine_hosts',
        'plugin.d_b_model.zones',
        'plugin.d_b_model.activities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ArtifactFeeds') ? [] : ['className' => 'DBModel\Model\Table\ArtifactFeedsTable'];
        $this->ArtifactFeeds = TableRegistry::get('ArtifactFeeds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ArtifactFeeds);

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
            'artifact_id' => 1,
            'solid_id' => 1,
            'bridge_id' => 1,
            'channel_id' => 1,
            'gmt_created' => 1473086645,
            'line' => 'artifact_feeds_line',
            'flag' => 'Ready'
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
        $artifactFeed = $this->ArtifactFeeds->newEntity($data);
        $this->assertEmpty($artifactFeed->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['artifact_id']);
        unset($data['solid_id']);
        unset($data['bridge_id']);
        unset($data['channel_id']);
        unset($data['gmt_created']);
        unset($data['line']);
        unset($data['flag']);
        $artifactFeed = $this->ArtifactFeeds->newEntity($data);
        $this->assertEmpty($artifactFeed->errors());
    }

    /**
     * Test putLine method. Expecting correct result.
     *
     * @return void
     */
    public function testPutLine()
    {
        $artifactId = 1;
        $text = 'new_line';
        $serverId = 1;
        $channelId = 1;
        $flag = 'Error';
        $solidId = 1;
        $result = $this->ArtifactFeeds->putLine($artifactId, $text, $serverId, $channelId, $flag, $solidId);
        $record = $this
                    ->ArtifactFeeds
                    ->find()
                    ->where([
                        'artifact_id' => $artifactId, 
                        'solid_id' => $solidId, 
                        'line' => $text, 
                        'bridge_id' => $serverId, 
                        'channel_id' => $channelId, 
                        'flag' => $flag, 
                        'gmt_created' => time()])
                    ->toArray();
        $this->assertNotEmpty($record);
        $this->assertTrue($result);
    }
}
