<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsrsFixture
 *
 */
class UsrsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'username' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'method' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'groops' => ['type' => 'text', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'roles' => ['type' => 'text', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'isroot' => ['type' => 'string', 'length' => 1, 'default' => 'N', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'u_iu_u' => ['type' => 'unique', 'columns' => ['username'], 'length' => []],
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
            'username' => 'root',
            'password' => 'f4351aff6d1b2b19dc2b2c46b96136dfd63f710b27858815a06b97e454c879b5',
            'method' => 'Local',
            'groops' => 'root',
            'roles' => 'Unassigned',
            'isroot' => 'N'
        ],
    ];
}
