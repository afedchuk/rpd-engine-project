<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssetsFixture
 *
 */
class AssetsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'product_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'gmt_created' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 1, 'default' => 'D', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'revision' => ['type' => 'string', 'length' => 255, 'default' => '0.0.0.[#]', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'nextrev' => ['type' => 'integer', 'length' => 10, 'default' => '1', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'locked' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'u_a_n' => ['type' => 'unique', 'columns' => ['name'], 'length' => []],
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
            'product_id' => 0,
            'gmt_created' => 1,
            'name' => 'package_1',
            'type' => 'D',
            'revision' => '0.0.0.[#]',
            'nextrev' => 1,
            'locked' => 0
        ],
         [
            'id' => 2,
            'product_id' => 0,
            'gmt_created' => 1,
            'name' => 'package_2',
            'type' => 'D',
            'revision' => '0.0.0.[#]',
            'nextrev' => 2,
            'locked' => 0
        ],
         [
            'id' => 3,
            'product_id' => 0,
            'gmt_created' => 1,
            'name' => 'package_3',
            'type' => 'D',
            'revision' => '0.0.0.[#]',
            'nextrev' => 1,
            'locked' => 0
        ],
    ];
}
