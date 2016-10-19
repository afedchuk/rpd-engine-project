<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DeliveryPropertiesFixture
 *
 */
class DeliveryPropertiesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'delivery_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'value' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'artifact_uri_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_indexes' => [
            'dta_delivery_properties' => ['type' => 'index', 'columns' => ['delivery_id', 'name'], 'length' => []],
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
            'delivery_id' => 1,
            'name' => 'test_pack',
            'value' => 'pack_ref',
            'artifact_uri_id' => 1
        ],
    ];
}
