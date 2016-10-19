<?php

use Cake\Database\Schema\Table;
// Create a table one column at a time.
$t = new Table('zones');
$t->addColumn('id', [
  'type' => 'integer',
  'length' => 11,
  'null' => false,
  'default' => null,
])->addColumn('name', [
  'type' => 'string',
  'length' => 255,
  // Create a fixed length (char field)
  'fixed' => true
])->addConstraint('primary', [
  'type' => 'primary',
  'columns' => ['id']
]);

// Schema\Table classes could also be created with array data
$t = new Table('zones', $columns);
var_dump($t);die;
