<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UrisFixture
 *
 */
class UrisFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'location' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'precision' => null, 'comment' => null, 'fixed' => null],
        'content' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'fixed' => null],
        'active' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => '\'y\'', 'precision' => null, 'comment' => null, 'fixed' => null],
        'splode' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => '\'n\'', 'precision' => null, 'comment' => null, 'fixed' => null],
        'flag' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => '\'n\'', 'precision' => null, 'comment' => null, 'fixed' => null],
        'asset_property_id' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'bridge_id' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'remote' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'module_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'fixed' => null],
        'sequence' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'fixed' => null],
        'asset_id' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'id' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
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
            'location' => 'file:///c:/tmp/juve.txt',
            'content' => 'Lorem ipsum dolor sit amet',
            'active' => 'y',
            'splode' => 'n',
            'flag' => 'n',
            'asset_property_id' => 1,
            'bridge_id' => 1,
            'remote' => 1,
            'module_name' => 'asset_file',
            'sequence' => 1,
            'name' => 'Test_reference',
            'asset_id' => 1,
            'id' => 1
        ],
         [
            'location' => 'file:///c:/tmp/juve.txt',
            'content' => 'Lorem ipsum dolor sit amet',
            'active' => 'y',
            'splode' => 'n',
            'flag' => 'n',
            'asset_property_id' => 1,
            'bridge_id' => 1,
            'remote' => 1,
            'module_name' => 'asset_file',
            'sequence' => 1,
            'name' => 'ref_4',
            'asset_id' => 1,
            'id' => 2
        ],
         [
            'location' => 'file:///c:/tmp/juve.txt',
            'content' => 'Lorem ipsum dolor sit amet',
            'active' => 'y',
            'splode' => 'n',
            'flag' => 'n',
            'asset_property_id' => 1,
            'bridge_id' => 1,
            'remote' => 1,
            'module_name' => 'asset_file',
            'sequence' => 1,
            'name' => 'ref_3',
            'asset_id' => 2,
            'id' => 3
        ],
        [
            'location' => 'file:///c:/tmp/juve.txt',
            'content' => 'Lorem ipsum dolor sit amet',
            'active' => 'y',
            'splode' => 'n',
            'flag' => 'n',
            'asset_property_id' => 1,
            'bridge_id' => 1,
            'remote' => 0,
            'module_name' => 'asset_file',
            'sequence' => 1,
            'name' => 'ref_3',
            'asset_id' => 2,
            'id' => 4
        ],
        [
            'location' => 'file:///c:/tmp/juve.txt',
            'content' => 'Lorem ipsum dolor sit amet',
            'active' => 'y',
            'splode' => 'n',
            'flag' => 'n',
            'asset_property_id' => 1,
            'bridge_id' => 3,
            'remote' => 0,
            'module_name' => 'asset_file',
            'sequence' => 1,
            'name' => 'ref_3',
            'asset_id' => 2,
            'id' => 5
        ],
        [
            'location' => 'file:///c:/tmp/ref.txt',
            'content' => 'ref_6_content',
            'active' => 'y',
            'splode' => 'n',
            'flag' => 'n',
            'asset_property_id' => 1,
            'bridge_id' => 1,
            'remote' => 0,
            'module_name' => 'reference_get',
            'sequence' => 1,
            'name' => 'ref_6',
            'asset_id' => 1,
            'id' => 6
        ],
    ];
}
