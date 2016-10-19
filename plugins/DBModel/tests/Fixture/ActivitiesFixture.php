<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ActivitiesFixture
 *
 */
class ActivitiesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'fixed' => null],
        'process_id' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'def_activity_id' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'lib_activity_id' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'flag' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => '\'WAIT\'', 'precision' => null, 'comment' => null, 'fixed' => null],
        'gmt_start' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'duration' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'activity_timeout' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
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
            'name' => 'SendContent',
            'process_id' => 1,
            'def_activity_id' => 1,
            'lib_activity_id' => 1,
            'flag' => 'STOPPED',
            'gmt_start' => 1451053690,
            'duration' => 19,
            'activity_timeout' => 0
        ],
        [
            'id' => 2,
            'name' => 'Execute',
            'process_id' => 1,
            'def_activity_id' => 1,
            'lib_activity_id' => 1,
            'flag' => 'ACTIVE',
            'gmt_start' => 1451055148,
            'duration' => 17,
            'activity_timeout' => 0
        ],
    ];
}
