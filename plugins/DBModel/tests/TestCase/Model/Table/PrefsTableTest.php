<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\PrefsTable;

/**
 * DBModel\Model\Table\PrefsTable Test Case
 */
class PrefsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\PrefsTable
     */
    public $Prefs;

    public $expectedData = [
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

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.prefs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Prefs') ? [] : ['className' => 'DBModel\Model\Table\PrefsTable'];
        $this->Prefs = TableRegistry::get('Prefs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Prefs);
        parent::tearDown();
    }
    
    /**
     * Test validateUniqueName method
     *
     * @return void
     */
    public function testValidateUniqueName()
    {
        $result = $this->Prefs->validateUniqueName('dashboard', []);
        $this->assertTrue($result);
    }

    /**
     * Test getPreference method
     *
     * @return void
     */
    public function testGetAllPreference()
    {
        $query = $this->Prefs->find('all')->where(['user_id' => 1])->select(['user_id', 'name', 'value']);
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $this->assertEquals($this->expectedData, $query->hydrate(false)->toArray());

        $query = $this->Prefs->find('all')->where(['user_id' => 0])->select(['user_id', 'name', 'value']);
        $this->assertNotEquals($this->expectedData, $query->hydrate(false)->toArray());
    }

    /**
     * Test getPreference method
     *
     * @return void
     */
    public function testGetPreferenceByName()
    {
        $query = $this->Prefs->find()->where(['user_id' => 1, 'name' => 'tz'])->select(['user_id', 'name', 'value']);
        $this->assertEquals([['user_id' => 1,'name' => 'tz', 'value' => 'America/Chicago']], $query->hydrate(false)->toArray());
    }

    /**
     * Test getPreference method
     *
     * @return void
     */
    public function testGetPreferenceByUserId()
    {
        $query = $this->Prefs->find()->where(['user_id' => 2])->select(['user_id', 'name', 'value']);
        $this->assertEquals(0, $query->count());
    }
}
