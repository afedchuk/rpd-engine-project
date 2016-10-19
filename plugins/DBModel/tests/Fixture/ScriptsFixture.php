<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ScriptsFixture
 *
 */
class ScriptsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'reference_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'platform_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'gmt_created' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'version' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'activ' => ['type' => 'string', 'length' => 255, 'default' => 'y', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'pack_id' => ['type' => 'integer', 'length' => 10, 'default' => '0', 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'md5' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'content' => ['type' => 'text', 'length' => 4000, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
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
            'reference_id' => 0,
            'platform_id' => 0,
            'gmt_created' => 1471530507,
            'version' => 0,
            'activ' => 'Y',
            'name' => 'EC2_instantiate_instances',
            'pack_id' => 1,
            'md5' => 'e712fc1966c4ef1dff76e8eecfc5f471',
            'content' => '#!/bin/bash'
        ],
    ];
}
