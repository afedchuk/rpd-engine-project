<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EnginesFixture
 *
 */
class EnginesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'hostname' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'pid' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'port' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'gmt_created' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'gmt_expires' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'count' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'activity' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'control' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'host_session_key' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'ie_hp' => ['type' => 'index', 'columns' => ['hostname', 'pid'], 'length' => []],
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
            'hostname' => 'Localhost',
            'pid' => 184,
            'port' => 8866,
            'gmt_created' => 1,
            'gmt_expires' => 1,
            'count' => 1,
            'activity' => 'Lorem ipsum dolor sit amet',
            'control' => 'Lorem ipsum dolor sit amet',
            'host_session_key' => 'xxx-234sdfx-1134'
        ],
        [
            'hostname' => 'WithZones',
            'pid' => 1832,
            'port' => 9955,
            'gmt_created' => 1,
            'gmt_expires' => 1,
            'count' => 1,
            'activity' => 'Lorem ipsum dolor sit amet',
            'control' => 'Lorem ipsum dolor sit amet',
            'host_session_key' => 'xxx-afq234sdfx-1134',
        ],
    ];
}
