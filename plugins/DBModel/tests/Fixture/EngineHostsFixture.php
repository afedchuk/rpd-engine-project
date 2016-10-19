<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EngineHostsFixture
 *
 */
class EngineHostsFixture extends TestFixture
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
        'session_key' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'max_engines' => ['type' => 'integer', 'length' => 10, 'default' => '20', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'gmt_expires' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'zone_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'u_ieh_h' => ['type' => 'unique', 'columns' => ['hostname'], 'length' => []],
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
            'hostname' => 'Win',
            'session_key' => 'xxx-afq127sdfx-1254',
            'max_engines' => 1,
            'gmt_expires' => 1451058020,
            'zone_id' => 1
        ],
        [
            // 'id' => 2,
            'hostname' => 'WithZones',
            'session_key' => 'xxx-afq234sdfx-1134',
            'max_engines' => 3,
            'gmt_expires' => 1451057922,
            'zone_id' => 2
        ],
    ];
}
