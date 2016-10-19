<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DeliverablesFixture
 *
 */
class DeliverablesFixture extends TestFixture
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
        'artifact_name' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 1, 'default' => 'D', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'asset_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'del_route_name_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'artifact_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'status' => ['type' => 'string', 'length' => 32, 'default' => 'Empty', 'null' => true, 'comment' => null, 'precision' => null, 'fixed' => null],
        'delivery_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'deliverable_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'gmt_created' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'locked' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'frozen' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'cloaked' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_indexes' => [
            'dta_deliverables' => ['type' => 'index', 'columns' => ['id', 'status'], 'length' => []],
            'dta_deliverables_8' => ['type' => 'index', 'columns' => ['asset_id'], 'length' => []],
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
            'name' => '0.0.0.1',
            'artifact_name' => 'package_1',
            'type' => 'D',
            'asset_id' => 1,
            'del_route_name_id' => 1,
            'artifact_id' => 1,
            'status' => 'Construct',
            'delivery_id' => 0,
            'deliverable_id' => 0,
            'gmt_created' => 11111111,
            'locked' => 0,
            'frozen' => 1,
            'cloaked' => 0
        ],
         [
            'id' => 2,
            'name' => '0.0.0.2',
            'artifact_name' => 'package_1',
            'type' => 'D',
            'asset_id' => 1,
            'del_route_name_id' => 1,
            'artifact_id' => 1,
            'status' => 'Ready',
            'delivery_id' => 0,
            'deliverable_id' => 0,
            'gmt_created' => 11111111,
            'locked' => 0,
            'frozen' => 0,
            'cloaked' => 0
        ],
         [
            'id' => 3,
            'name' => '0.0.0.3',
            'artifact_name' => 'package_1',
            'type' => 'D',
            'asset_id' => 1,
            'del_route_name_id' => 1,
            'artifact_id' => 1,
            'status' => 'Empty',
            'delivery_id' => 0,
            'deliverable_id' => 0,
            'gmt_created' => 11111111,
            'locked' => 0,
            'frozen' => 0,
            'cloaked' => 0
        ],
    ];
}
