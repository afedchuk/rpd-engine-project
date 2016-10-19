<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ZonePropertiesFixture
 *
 */
class ZonePropertiesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'name' => ['type' => 'string', 'length' => 255, 'default' => '0', 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'value' => ['type' => 'text', 'length' => 4000, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'zone_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
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
            'name' => 'zone_property_name',
            'value' => 'zone_property_value',
            'zone_id' => 1
        ],
    ];
}
