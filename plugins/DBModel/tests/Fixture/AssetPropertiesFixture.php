<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssetPropertiesFixture
 *
 */
class AssetPropertiesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'asset_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'value' => ['type' => 'text', 'length' => 255, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'locked' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
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
            'asset_id' => 1,
            'name' => 'first_prop',
            'value' => 'first_val',
            'locked' => 0
        ],
        [
            // 'id' => 2,
            'asset_id' => 1,
            'name' => 'second_prop',
            'value' => 'second_val',
            'locked' => 0
        ],
        [
            // 'id' => 3,
            'asset_id' => 2,
            'name' => 'third_prop',
            'value' => 'third_val',
            'locked' => 0
        ],
    ];
}
