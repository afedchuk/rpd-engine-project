<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LibActivitiesFixture
 *
 */
class LibActivitiesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'name' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'connectivity' => ['type' => 'string', 'length' => 255, 'default' => 'OPEN', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'needs_channel' => ['type' => 'string', 'length' => 255, 'default' => 'N', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'u_ula_n' => ['type' => 'unique', 'columns' => ['name'], 'length' => []],
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
            'name' => 'Lorem ipsum dolor sit amet',
            'connectivity' => 'Lorem ipsum dolor sit amet',
            'needs_channel' => 'Lorem ipsum dolor sit ame'
        ],
    ];
}
