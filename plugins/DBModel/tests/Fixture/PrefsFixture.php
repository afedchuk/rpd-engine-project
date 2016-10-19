<?php
namespace DBModel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PrefsFixture
 *
 */
class PrefsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => true],
        'user_id' => ['type' => 'integer', 'length' => 11, 'null' => true, 'default' => '0', 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'precision' => null, 'comment' => null, 'fixed' => null],
        'value' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'precision' => null, 'comment' => null, 'fixed' => null],
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
        ['user_id' => 1,'name' => 'artifact_store_uri',       'value' => 'db://base64'],
        ['user_id' => 1,'name' => 'auth_login_driver',        'value' => 'auth_local'],
        ['user_id' => 1,'name' => 'bridge_connect_timeout',   'value' => '20'],
        ['user_id' => 1,'name' => 'bridge_read_timeout',      'value' => '300'],
        ['user_id' => 1,'name' => 'bridge_write_timeout',     'value' => '300'],
        ['user_id' => 1,'name' => 'case_sensitive_config_expansion','value' => 'n'],
        ['user_id' => 1,'name' => 'config_process_keep_time', 'value' => '3600'],
        ['user_id' => 1,'name' => 'date_format',              'value' => 'D M j h:ia'],
        ['user_id' => 1,'name' => 'dashboard_instance_age',   'value' => '30'],
        ['user_id' => 1,'name' => 'dashboard',                'value' => 'launchpad'],
        ['user_id' => 1,'name' => 'default_domain',           'value' => 'yourhost.com'],
        ['user_id' => 1,'name' => 'default_user_role',        'value' => ''],
        ['user_id' => 1,'name' => 'engine_life_actions',      'value' => '100'],
        ['user_id' => 1,'name' => 'engine_life_hr',           'value' => '24'],
        ['user_id' => 1,'name' => 'engine_tick_sec',          'value' => '3'],
        ['user_id' => 1,'name' => 'engine_watchdog_sec',      'value' => '5'],
        ['user_id' => 1,'name' => 'engine_zombie_check',      'value' => '3000'],
        ['user_id' => 1,'name' => 'ignore_smtp_send_errors',  'value' => 'n'],
        ['user_id' => 1,'name' => 'items_per_page',           'value' => '20'],
        ['user_id' => 1,'name' => 'lang',                     'value' => 'eng'],
        ['user_id' => 1,'name' => 'lock_timeout',             'value' => '120'],
        ['user_id' => 1,'name' => 'log_date_format',          'value' => 'H:i:s'],
        ['user_id' => 1,'name' => 'mail_from',                'value' => 'root@yourhost.com'],
        ['user_id' => 1,'name' => 'mail_smtp_authpass',       'value' => ''],
        ['user_id' => 1,'name' => 'mail_smtp_authuser',       'value' => ''],
        ['user_id' => 1,'name' => 'mail_smtp_helo',           'value' => ''],
        ['user_id' => 1,'name' => 'mail_smtp_port',           'value' => '25'],
        ['user_id' => 1,'name' => 'mail_smtp_server',         'value' => 'localhost'],
        ['user_id' => 1,'name' => 'mail_smtp_timeout',        'value' => '30'],
        ['user_id' => 1,'name' => 'no_logins_message',        'value' => ''],
        ['user_id' => 1,'name' => 'pre_login_message',        'value' => ''],
        ['user_id' => 1,'name' => 'product_version',          'value' => '5.0.00.00'],
        ['user_id' => 1,'name' => 'show_api_detail',          'value' => 'n'],
        ['user_id' => 1,'name' => 'signoff_reminder_days',    'value' => '1'],
        ['user_id' => 1,'name' => 'show_transfer_percentage', 'value' => 'n'],
        ['user_id' => 1,'name' => 'solid_toc_has_dirs',       'value' => 'n'],
        ['user_id' => 1,'name' => 'store_actions_in_instance','value' => 'n'],
        ['user_id' => 1,'name' => 'store_block_size',         'value' => '32767'],
        ['user_id' => 1,'name' => 'transfer_block_size',      'value' => '16384'],
        ['user_id' => 1,'name' => 'tz',                       'value' => 'America/Chicago'],
        ['user_id' => 1,'name' => 'auto_logout_minutes',      'value' => '1440'],
        ['user_id' => 1,'name' => 'add_instance_user_info',   'value' => 'n'],
        ['user_id' => 1,'name' => 'semaphore_default_lifespan_hr',   'value' => '24'],
        ['user_id' => 1,'name' => 'log_level',   'value' => 'error']
    ];
}
