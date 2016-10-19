<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ModulesFixture
 *
 */
class ModulesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'platform_id' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'fixed' => null],
        'version' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'gmt_created' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'siz' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'md5' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'fixed' => null],
        'bits_id' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'description' => ['type' => 'string', 'length' => '255', 'null' => true, 'default' => null, 'precision' => null, 'comment' => null, 'fixed' => null],
        '_constraints' => [
            'U_IM_PINV' => ['type' => 'unique', 'columns' => ['version', 'name', 'platform_id'], 'length' => []],
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
            'platform_id' => 1,
            'name' => 'Lorem ipsum dolor sit amet',
            'version' => 1,
            'gmt_created' => 1,
            'siz' => 1,
            'md5' => 'Lorem ipsum dolor sit amet',
            'bits_id' => 1,
            'description' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
