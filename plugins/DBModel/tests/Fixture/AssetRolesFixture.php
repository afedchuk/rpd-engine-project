<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssetRolesFixture
 *
 */
class AssetRolesFixture extends TestFixture
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
        'role_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_indexes' => [
            'dta_asset_roles_c' => ['type' => 'index', 'columns' => ['id', 'asset_id', 'role_id'], 'length' => []],
            'dta_asset_roles' => ['type' => 'index', 'columns' => ['id', 'asset_id'], 'length' => []],
            'dta_asset_roles_c_8' => ['type' => 'index', 'columns' => ['asset_id', 'role_id'], 'length' => []],
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
            'asset_id' => 1,
            'role_id' => 1
        ],
    ];
}
