<?php
/* SVN FILE: $Id$ */
/* core schema generated on: 2012-09-14 12:09:41 : 1347643361*/
use Cake\Database\Schema\Table;
class coreSchema extends CakeSchema {
	var $name = 'core';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}


	var $access_groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'dn' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'filters' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'paths' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $access_paths = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'ap_category_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'paths' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $activities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'def_activity_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'lib_activity_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'flag' => array('type' => 'string', 'null' => true, 'default' => 'WAIT'),
		'gmt_start' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'duration' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'activity_timeout' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $activity_depends = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'activity_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'def_depend_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'pass', 'length' => 16),
		'scope' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $analyzer_maps = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'uri_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'analyzer_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $analyzer_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'analyzer_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $analyzers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'module' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'copy_on_explode' => array('type' => 'string', 'null' => true, 'default' => 'n'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $ap_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $api = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => true),
		'token' => array('type' => 'string', 'null' => true),
		'gmt_expires' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'event_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'groops' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'toc' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $artifact_feeds = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'artifact_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'solid_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'bridge_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'line' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'flag' => array('type' => 'string', 'null' => true, 'default' => 'O', 'length' => 1),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $artifact_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'artifact_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'text', 'null' => true),
		'locked' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'uri_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $artifact_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'artifact_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $artifacts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'deliverable_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_rev_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'status' => array('type' => 'string', 'null' => true, 'default' => 'Empty'),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'revision' => array('type' => 'string', 'null' => true, 'default' => '0.0.0.[#]'),
		'nextrev' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'locked' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'ref_artifact_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $asset_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'asset_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'text', 'null' => true),
		'locked' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $asset_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'asset_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $assets = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'product_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'D', 'length' => 1),
		'revision' => array('type' => 'string', 'null' => true, 'default' => '0.0.0.[#]'),
		'nextrev' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'locked' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $auditargs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'audit_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $bits = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'module_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $blobs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'solid_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $bridges = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'hostname' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'despatcher' => array('type' => 'string', 'null' => true),
		'platform' => array('type' => 'string', 'null' => true, 'default' => 'Unknown'),
		'remote_platform' => array('type' => 'string', 'null' => true, 'default' => 'Unknown'),
		'channel_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'vm_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'zone_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'agent_info' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'agent_up' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'agent_writable' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $bridge_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 255),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'bridge_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
    'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $bridge_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'bridge_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $build_checkouts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'engine_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'solid_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'build_path' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'status' => array('type' => 'string', 'null' => true, 'default' => 'Q', 'length' => 1),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $channel_confs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'channel_rev_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'bytes' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'status' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'md5' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'gen_content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $channel_processes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'channel_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'sync', 'length' => 32),
		'status' => array('type' => 'string', 'null' => true, 'default' => 'init', 'length' => 32),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $channel_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'channel_property_set_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $channel_property_sets = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'channel_rev_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $channel_revs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'bridge_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'state' => array('type' => 'string', 'null' => true, 'default' => 'Active', 'length' => 12),
		'ref_state' => array('type' => 'string', 'null' => true, 'length' => 32),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $channel_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'channel_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $channel_type_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'channel_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $channel_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'failure_def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'provision_def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'post_def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'removal_def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'concurrency' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'ref_channel_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'pack_id' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'managed' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 1),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'drift_rules' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $channel_type_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'channel_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $channels = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'channel_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'owner_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_rev_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'bridge_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'lb_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_conf_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_property_set_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'drift_rules' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $cmaps = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'pack_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true, 'default' => 'Ignore'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $dbinfos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'gmt_sample' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sample_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true, 'default' => 'Ignore'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $def_activities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'active' => array('type' => 'string', 'null' => true, 'default' => 'y', 'length' => 1),
		'def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'lib_activity_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'activity_timeout' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $def_activity_depends = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'def_activity_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'def_depend_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'pass', 'length' => 16),
		'scope' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $def_processes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'Generic'),
		'active' => array('type' => 'string', 'null' => true, 'default' => 'No', 'length' => 12),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $def_process_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $def_task_param_defaults = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'def_task_param_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'lib_task_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'def_activity_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $def_task_params = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'def_activity_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'lib_task_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'lib_task_param_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'occurance' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'correlation' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'optional' => array('type' => 'string', 'null' => true, 'default' => 'Yes', 'length' => 16),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'separator' => array('type' => 'string', 'null' => true),
		'modifiable' => array('type' => 'string', 'null' => true, 'default' => 'Yes', 'length' => 16),
		'explode' => array('type' => 'string', 'null' => true, 'default' => 'None', 'length' => 16),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $del_env_channels = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'del_env_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $del_env_pool_channels = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'del_env_pool_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $del_env_pools = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'del_env_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $del_env_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'del_env_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $del_env_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'del_env_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $del_env_signoffs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'del_env_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'required'),
		'contact' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $del_envs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'notification_template_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'init_def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'success_def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'failure_def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'drift_def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'drift_execs_failure' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'delivery_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'group_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'protected' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $del_route_names = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'Open', 'length' => 12),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $del_routes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'del_route_name_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'del_env_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'groop_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $deliverable_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'deliverable_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $deliverables = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'artifact_name' => array('type' => 'string', 'null' => true),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'D', 'length' => 1),
		'asset_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'del_route_name_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'artifact_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'status' => array('type' => 'string', 'null' => true, 'default' => 'Empty', 'length' => 32),
		'delivery_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'deliverable_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'locked' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'frozen' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'cloaked' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $deliveries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'deliverable_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'D', 'length' => 1),
		'del_env_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'action' => array('type' => 'string', 'null' => true, 'default' => 'GO', 'length' => 32),
		'delivery_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'pre_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'post_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'vm_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'engine_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'status' => array('type' => 'string', 'null' => true),
		'pause_after' => array('type' => 'string', 'null' => true),
		'gmt_start' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'duration' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'active_pool_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'target_pool' => array('type' => 'string', 'null' => true),
		'drift_execs_failure' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $delivery_channels = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'delivery_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $delivery_preview_models = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'delivery_preview_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'uri_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'content_name' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'handler_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $delivery_previews = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'user_id' => array('type' => 'string', 'null' => true),
		'asset_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'del_env_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'action' => array('type' => 'string', 'null' => true, 'default' => 'go'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $delivery_processes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'delivery_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'solid_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'handler_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'provision_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'pattern' => array('type' => 'string', 'null' => true),
		'status' => array('type' => 'string', 'null' => true),
		'paths' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $delivery_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'delivery_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
        'artifact_uri_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $delivery_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'delivery_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $delivery_signoffs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'delivery_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'notification_template_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'required'),
		'contact' => array('type' => 'string', 'null' => true),
		'signoff' => array('type' => 'string', 'null' => true),
		'gmt_notified' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_signed' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_active' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'flag' => array('type' => 'string', 'null' => true, 'default' => 'a', 'length' => 1),
		'note' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $delivery_wiz_param_defaults = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $delivery_wiz_param_opts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $delivery_wiz_params = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'wizard_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'occurance' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'correlation' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'optional' => array('type' => 'string', 'null' => true, 'default' => 'Yes', 'length' => 16),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $delivery_wizards = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => true),
		'wizard' => array('type' => 'string', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $engine_hosts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'hostname' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'session_key' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'max_engines' => array('type' => 'integer', 'null' => true, 'default' => '20'),
		'gmt_expires' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'zone_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $engines = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'hostname' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'pid' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'port' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'gmt_expires' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'count' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'activity' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'control' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'host_session_key' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $events = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'source' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $filter_patterns = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'filter_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'pattern' => array('type' => 'string', 'null' => true),
		'action' => array('type' => 'string', 'null' => true, 'length' => 1),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $filters = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $handler_patterns = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'active' => array('type' => 'string', 'null' => true, 'default' => 'y', 'length' => 1),
		'channel_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'handler_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'F', 'length' => 1),
		'pattern' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $handlers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'go_def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'goback_def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'post_def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $handler_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'handler_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $lb_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'lb_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $lb_userprops = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'lb_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $lbs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'module' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $lib_activities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'connectivity' => array('type' => 'string', 'null' => true, 'default' => 'OPEN'),
		'needs_channel' => array('type' => 'string', 'null' => true, 'default' => 'N', 'length' => 1),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $lib_task_depends = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'lib_task_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'lib_depend_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $lib_task_param_defaults = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'lib_task_param_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $lib_task_param_opts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'lib_task_param_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $lib_task_params = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'lib_task_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'occurance' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'correlation' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'optional' => array('type' => 'string', 'null' => true, 'default' => 'Yes', 'length' => 16),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'separator' => array('type' => 'string', 'null' => true),
		'modifiable' => array('type' => 'string', 'null' => true, 'default' => 'Yes', 'length' => 16),
		'explode' => array('type' => 'string', 'null' => true, 'default' => 'None', 'length' => 16),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $lib_tasks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'lib_activity_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'explode_type' => array('type' => 'string', 'null' => true, 'default' => 'REALM', 'length' => 32),
		'module' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'needs_channel' => array('type' => 'string', 'null' => true, 'default' => 'N', 'length' => 32),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $listener_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'listener_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $listeners = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'module' => array('type' => 'string', 'null' => true),
		'active' => array('type' => 'string', 'null' => true, 'default' => 'n', 'length' => 1),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $loches = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'owner' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'gmt_expires' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $lognotes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'pack_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'pattern' => array('type' => 'string', 'null' => true),
		'notes' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $messages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'message' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $metuh_confs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'feeldname' => array('type' => 'string', 'null' => true),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'T', 'length' => 1),
		'bottom' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'top' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'vals' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $modules = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'platform_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'version' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'siz' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'md5' => array('type' => 'string', 'null' => true),
		'bits_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $notification_template_langs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'notification_template_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'lang' => array('type' => 'string', 'null' => true, 'default' => 'en_US'),
		'subject' => array('type' => 'string', 'null' => true),
		'body' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $notification_templates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $oddits = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'event_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'message' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $packs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $platform_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'platform_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $platforms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'reference_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $platstrings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'platform_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'pattern' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $prefs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $process_depends = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'process_depend_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $processes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'def_process_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'Generic'),
		'flag' => array('type' => 'string', 'null' => true, 'default' => 'QUEUED'),
		'engine_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_flag' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_start' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'duration' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'message' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $product_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'product_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $product_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'product_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $products = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 255),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $renores = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'pack_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'platform_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'pattern' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $report_wiz_param_defaults = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $report_wiz_param_opts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $report_wiz_params = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'wizard_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'occurance' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'correlation' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'optional' => array('type' => 'string', 'null' => true, 'default' => 'Yes', 'length' => 16),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $report_wizards = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => true),
		'wizard' => array('type' => 'string', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $sched_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'sched_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $scheds = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'gmt_fire' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'active' => array('type' => 'string', 'null' => true, 'default' => 'y', 'length' => 1),
		'name' => array('type' => 'string', 'null' => true),
		'module' => array('type' => 'string', 'null' => true),
		'spec' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $scripts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'reference_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'platform_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'version' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'activ' => array('type' => 'string', 'null' => true, 'default' => 'y', 'length' => 1),
		'name' => array('type' => 'string', 'null' => true),
		'pack_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'md5' => array('type' => 'string', 'null' => true),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $solid_analyzer_maps = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'solid_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'analyzer_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $solid_depends = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'solid_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'solid_depend_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'pass'),
		'scope' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $solid_patterns = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'uri_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'flag' => array('type' => 'string', 'null' => true, 'length' => 1),
		'pattern' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $solids = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'artifact_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'location' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'store_uri' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'bridge_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'module_name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'siz' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'pct' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'status' => array('type' => 'string', 'null' => false, 'default' => 'Queued'),
		'gmt_fetched' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'analyz' => array('type' => 'string', 'null' => true, 'default' => 'y', 'length' => 1),
		'reference_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'ref_artifact_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'delivery_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'toc' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'md5' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'splode' => array('type' => 'string', 'null' => true, 'default' => 'n', 'length' => 1),
		'active' => array('type' => 'string', 'null' => true, 'default' => 'y', 'length' => 1),
		'solid_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'uri_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'engine_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'deliverable_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'product_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'stamp' => array('type' => 'string', 'null' => true, 'default' => '0'),
		'meta' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'remote_location' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'uri_require' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $spin_add_activity_task_refs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'lib_task_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $spin_edit_activity_task_refs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'def_task_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $spin_preview_models = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'spin_preview_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'uri_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'content_name' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'handler_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $spin_previews = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'user_id' => array('type' => 'string', 'null' => true),
		'asset_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'del_env_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'action' => array('type' => 'string', 'null' => true, 'default' => 'go'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $spin_wiz_param_defaults = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $spin_wiz_param_opts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $spin_wiz_params = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'wizard_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'occurance' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'correlation' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'optional' => array('type' => 'string', 'null' => true, 'default' => 'Yes', 'length' => 16),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $spin_wizards = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => true),
		'wizard' => array('type' => 'string', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $task_depends = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'task_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'lib_depend_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $task_feeds = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'task_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gmt_created' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'line' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'flag' => array('type' => 'string', 'null' => true, 'default' => 'O', 'length' => 1),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $task_param_defaults = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'task_param_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $task_param_opts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'task_param_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $task_params = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'task_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'activity_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'occurance' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'correlation' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'optional' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 16),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'separator' => array('type' => 'string', 'null' => true),
		'modifiable' => array('type' => 'string', 'null' => true, 'default' => 'Yes', 'length' => 16),
		'explode' => array('type' => 'string', 'null' => true, 'default' => 'None', 'length' => 16),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $tasks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'activity_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'lib_task_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'engine_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'channel_rev_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'explode_type' => array('type' => 'string', 'null' => true, 'default' => 'REALM', 'length' => 32),
		'module' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'flag' => array('type' => 'string', 'null' => true, 'default' => 'WAIT'),
		'gmt_start' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'duration' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'bridge_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $tocs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'solid_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'typ' => array('type' => 'string', 'null' => true, 'default' => 'F', 'length' => 1),
		'path' => array('type' => 'string', 'null' => true),
		'md5' => array('type' => 'string', 'null' => true),
		'siz' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'offset' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $topo_wiz_param_defaults = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $topo_wiz_param_opts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $topo_wiz_params = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'wizard_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'occurance' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'correlation' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'optional' => array('type' => 'string', 'null' => true, 'default' => 'Yes', 'length' => 16),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $topo_wizards = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => true),
		'wizard' => array('type' => 'string', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $uri_depends = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'uri_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'uri_depend_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'pass'),
		'scope' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
    var $uri_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'uri_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 255),
		'locked' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $uris = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'asset_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'location' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'module_name' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'remote' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'bridge_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'asset_property_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'flag' => array('type' => 'string', 'null' => true, 'default' => 'n', 'length' => 1),
		'splode' => array('type' => 'string', 'null' => true, 'default' => 'n', 'length' => 1),
		'active' => array('type' => 'string', 'null' => true, 'default' => 'y', 'length' => 1),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $usrs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'password' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'method' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'groops' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'roles' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'isroot' => array('type' => 'string', 'null' => true, 'default' => 'N', 'length' => 1),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $vm_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'vm_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $vm_userprops = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'vm_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $vms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'module' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $wb_add_activity_task_refs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'lib_task_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $wb_edit_activity_task_refs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'def_task_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $wb_wiz_param_defaults = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $wb_wiz_param_opts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'value' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $wb_wiz_params = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiz_param_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'wizard_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'occurance' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'correlation' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'optional' => array('type' => 'string', 'null' => true, 'default' => 'Yes', 'length' => 16),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $wb_wizards = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => true),
		'wizard' => array('type' => 'string', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $zones = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $zone_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 255),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'zone_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
    	'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
    var $sched_uri_asset_props = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'sched_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 11),
        'property_type' => array('type' => 'integer', 'null' => false, 'default' => 0, 'length' => 5),
        'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'value' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'property_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );
    var $sched_selected_options = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'sched_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 11),
        'type' => array('type' => 'string', 'null' => false, 'default' => 0, 'length' => 8),
        'option_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );
}
?>
