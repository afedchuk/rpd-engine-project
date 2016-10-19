<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TasksFixture
 *
 */
class TasksFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'name' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'activity_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'lib_task_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'engine_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'channel_rev_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'explode_type' => ['type' => 'string', 'length' => 32, 'default' => 'REALM', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'module' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'flag' => ['type' => 'string', 'length' => 255, 'default' => 'WAIT', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'gmt_start' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'duration' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'bridge_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_indexes' => [
            'dta_tasks' => ['type' => 'index', 'columns' => ['id', 'engine_id', 'flag'], 'length' => []],
            'dta_tasks_c' => ['type' => 'index', 'columns' => ['id', 'engine_id'], 'length' => []],
            'it_ai' => ['type' => 'index', 'columns' => ['activity_id'], 'length' => []],
            'it_f' => ['type' => 'index', 'columns' => ['flag'], 'length' => []],
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
            'name' => 'Send Instance Content',
            'activity_id' => 1,
            'lib_task_id' => 18,
            'engine_id' => 0,
            'channel_rev_id' => 1,
            'explode_type' => 'NONE',
            'module' => 'file_put',
            'flag' => 'ENGINEWAIT',
            'gmt_start' => 1451052860,
            'duration' => 4,
            'bridge_id' => 1
        ],
        [
            'id' => 2,
            'name' => 'Sleep',
            'activity_id' => 3,
            'lib_task_id' => 4,
            'engine_id' => 0,
            'channel_rev_id' => 12,
            'explode_type' => 'NONE',
            'module' => 'command',
            'flag' => 'REENTER',
            'gmt_start' => 1451056066,
            'duration' => 13,
            'bridge_id' => 2
        ]
    ];
}
