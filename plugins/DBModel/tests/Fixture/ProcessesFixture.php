<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProcessesFixture
 *
 */
class ProcessesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'def_process_id' => ['type' => 'integer', 'length' => 11, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => '\'Generic\'', 'precision' => null, 'comment' => null, 'fixed' => null],
        'flag' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => '\'QUEUED\'', 'precision' => null, 'comment' => null, 'fixed' => null],
        'engine_id' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'gmt_flag' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'gmt_start' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'duration' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'message' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'fixed' => null],
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
            'def_process_id' => 1,
            'name' => 'Sample File Deploy Process',
            'type' => 'Delivery',
            'flag' => 'STOPPED',
            'engine_id' => 0,
            'gmt_flag' => 1451052865,
            'gmt_start' => 1451052860,
            'duration' => 5,
            'message' => 'Processing'
        ],
        [
            'id' => 2,
            'def_process_id' => 1,
            'name' => 'Remove Servers from Load Balancer',
            'type' => 'Resource',
            'flag' => 'COMPLETE',
            'engine_id' => 0,
            'gmt_flag' => 1451052859,
            'gmt_start' => 1451052859,
            'duration' => 0,
            'message' => 'Processing'
        ],
        [
            'id' => 3,
            'def_process_id' => 1,
            'name' => 'Remove Servers',
            'type' => 'Delivery',
            'flag' => 'QUEUED',
            'engine_id' => 0,
            'gmt_flag' => 1451052725,
            'gmt_start' => 1451052725,
            'duration' => 0,
            'message' => 'Processing'
        ],
        [
            'id' => 4,
            'def_process_id' => 1,
            'name' => 'Process',
            'type' => 'Delivery',
            'flag' => 'ACTIVE',
            'engine_id' => 1,
            'gmt_flag' => 1451052650,
            'gmt_start' => 1451052645,
            'duration' => 5,
            'message' => 'Processing'
        ],
    ];
}
