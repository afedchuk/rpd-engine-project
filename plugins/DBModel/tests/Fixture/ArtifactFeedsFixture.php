<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ArtifactFeedsFixture
 *
 */
class ArtifactFeedsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'artifact_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'solid_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'bridge_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'channel_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'gmt_created' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'line' => ['type' => 'text', 'length' => 4000, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'flag' => ['type' => 'string', 'length' => 255, 'default' => 'O', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'iaf_ai' => ['type' => 'index', 'columns' => ['artifact_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            // 'id' => 1,
            'artifact_id' => 1,
            'solid_id' => 1,
            'bridge_id' => 1,
            'channel_id' => 1,
            'gmt_created' => 1473088860,
            'line' => 'artifact_feeds_line',
            'flag' => 'Ready'
        ],
    ];
}
