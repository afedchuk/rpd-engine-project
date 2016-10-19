<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BridgesFixture
 *
 */
class BridgesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'hostname' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'despatcher' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'platform' => ['type' => 'string', 'length' => 255, 'default' => 'Unknown', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'remote_platform' => ['type' => 'string', 'length' => 255, 'default' => 'Unknown', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'channel_type_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'vm_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'zone_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'agent_info' => ['type' => 'text', 'length' => 4000, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'agent_up' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'agent_writable' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'u_b_h' => ['type' => 'unique', 'columns' => ['hostname'], 'length' => []],
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
            'hostname' => 'Lorem ipsum dolor sit amet',
            'despatcher' => 'Lorem ipsum dolor sit amet',
            'platform' => 'Lorem ipsum dolor sit amet',
            'remote_platform' => 'Lorem ipsum dolor sit amet',
            'channel_type_id' => 1,
            'vm_id' => 1,
            'zone_id' => 1,
            'agent_info' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'agent_up' => 1,
            'agent_writable' => 1
        ],
        [
            'id' => 2,
            'hostname' => 'WithZone',
            'despatcher' => 'Lorem ipsum dolor sit amet',
            'platform' => 'Linux',
            'remote_platform' => 'Lorem ipsum dolor sit amet',
            'channel_type_id' => 1,
            'vm_id' => 1,
            'zone_id' => 2,
            'agent_info' => ' tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'agent_up' => 1,
            'agent_writable' => 1
        ],
         [
            'id' => 3,
            'hostname' => 'NoZone',
            'despatcher' => 'Lorem ipsum dolor sit amet',
            'platform' => 'Linux',
            'remote_platform' => 'Lorem ipsum dolor sit amet',
            'channel_type_id' => 1,
            'vm_id' => 1,
            'zone_id' => 0,
            'agent_info' => ' tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'agent_up' => 1,
            'agent_writable' => 1
        ],
    ];
}
