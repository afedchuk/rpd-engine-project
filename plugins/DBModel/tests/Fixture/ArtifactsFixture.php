<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ArtifactsFixture
 *
 */
class ArtifactsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'deliverable_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'channel_rev_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'status' => ['type' => 'string', 'length' => 255, 'default' => 'Empty', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'gmt_created' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'revision' => ['type' => 'string', 'length' => 255, 'default' => '0.0.0.[#]', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'nextrev' => ['type' => 'integer', 'length' => 10, 'default' => '1', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'locked' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'ref_artifact_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_indexes' => [
            'dta_artifacts' => ['type' => 'index', 'columns' => ['id', 'deliverable_id', 'name', 'ref_artifact_id'], 'length' => []],
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
            'id' => 1,
            'deliverable_id' => 1,
            'channel_rev_id' => 1,
            'name' => 'Lorem ipsum dolor sit amet',
            'status' => 'Empty',
            'gmt_created' => 1,
            'revision' => 'Lorem ipsum dolor sit amet',
            'nextrev' => 1,
            'locked' => 1,
            'ref_artifact_id' => 0
        ],
         [
            'id' => 2,
            'deliverable_id' => 2,
            'channel_rev_id' => 2,
            'name' => 'null_pack',
            'status' => 'Empty',
            'gmt_created' => 0,
            'revision' => '0.0.0.[#]',
            'nextrev' => 1,
            'locked' => 0,
            'ref_artifact_id' => 0
        ],
        [
            'id' => 3,
            'deliverable_id' => 2,
            'channel_rev_id' => 2,
            'name' => 'null_pack',
            'status' => 'Constructing',
            'gmt_created' => 0,
            'revision' => '0.0.0.[#]',
            'nextrev' => 1,
            'locked' => 0,
        ],
        [
        [
            'id' => 4,
            'deliverable_id' => 2,
            'channel_rev_id' => 2,
            'name' => 'null_pack',
            'status' => 'Error',
            'gmt_created' => 0,
            'revision' => '0.0.0.[#]',
            'nextrev' => 1,
            'locked' => 0,
            'ref_artifact_id' => 1
        ],
        [
            'id' => 5,
            'deliverable_id' => 2,
            'channel_rev_id' => 2,
            'name' => 'null_pack',
            'status' => 'Ready',
            'gmt_created' => 0,
            'revision' => '0.0.0.[#]',
            'nextrev' => 1,
            'locked' => 0,
            'ref_artifact_id' => 2
        ],
        [
            'id' => 6,
            'deliverable_id' => 2,
            'channel_rev_id' => 2,
            'name' => 'null_pack',
            'status' => 'Ready',
            'gmt_created' => 0,
            'revision' => '0.0.0.[#]',
            'nextrev' => 1,
            'locked' => 0,
            'ref_artifact_id' => 2
        ],
            'id' => 7,
            'deliverable_id' => 2,
            'channel_rev_id' => 2,
            'name' => 'null_pack',
            'status' => 'Empty',
            'gmt_created' => 0,
            'revision' => '0.0.0.[#]',
            'nextrev' => 1,
            'locked' => 0,
            'ref_artifact_id' => 0
        ],

        [
            'id' => 8,
            'deliverable_id' => 2,
            'channel_rev_id' => 2,
            'name' => 'null_pack',
            'status' => 'Constructing',
            'gmt_created' => 0,
            'revision' => '0.0.0.[#]',
            'nextrev' => 1,
            'locked' => 0,
            'ref_artifact_id' => 1
        ],
        [
            'id' => 3,
            'deliverable_id' => 2,
            'channel_rev_id' => 1,
            'name' => 'artifact_name',
            'status' => 'Ready',
            'gmt_created' => 1,
            'revision' => 'revision',
            'nextrev' => 1,
            'locked' => 1,
            'ref_artifact_id' => 0
        ],
         [
            'id' => 9,
            'deliverable_id' => 2,
            'channel_rev_id' => 2,
            'name' => 'null_pack',
            'status' => 'Empty',
            'gmt_created' => 0,
            'revision' => '0.0.0.[#]',
            'nextrev' => 1,
            'locked' => 0,
            'ref_artifact_id' => 8
        ],
        [
            'id' => 10,
            'deliverable_id' => 2,
            'channel_rev_id' => 2,
            'name' => 'null_pack',
            'status' => 'Empty',
            'gmt_created' => 0,
            'revision' => '0.0.0.[#]',
            'nextrev' => 1,
            'locked' => 0,
            'ref_artifact_id' => 8
        ],
    ];
}
