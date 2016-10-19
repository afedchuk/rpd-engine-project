<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ApiFixture
 *
 */
class ApiFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'api';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'toc' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'fixed' => null],
        'groops' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'fixed' => null],
        'event_id' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'gmt_expires' => ['type' => 'integer', 'length' => 10, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'token' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'fixed' => null],
        'username' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'NULL', 'precision' => null, 'comment' => null, 'fixed' => null],
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
            'toc' => 'toc',
            'groops' => 'group',
            'event_id' => 0,
            'gmt_expires' => 1476290340,
            'token' => '57d6da30-aef0-4601-88e5-1940ac166b3f',
            'username' => 'root',
            // 'id' => 1
        ],
    ];
}
