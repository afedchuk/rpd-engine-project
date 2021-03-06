<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotificationTemplateLangsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotificationTemplateLangsTable Test Case
 */
class NotificationTemplateLangsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NotificationTemplateLangsTable
     */
    public $NotificationTemplateLangs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.notification_template_langs',
        'app.notification_templates',
        'app.del_envs',
        'app.init_def_processes',
        'app.success_def_processes',
        'app.failure_def_processes',
        'app.drift_def_processes',
        'app.deliveries',
        'app.groups',
        'app.del_env_channels',
        'app.del_env_pools',
        'app.del_env_properties',
        'app.del_env_roles',
        'app.del_env_signoffs',
        'app.del_routes',
        'app.delivery_previews',
        'app.spin_previews',
        'app.delivery_signoffs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('NotificationTemplateLangs') ? [] : ['className' => 'App\Model\Table\NotificationTemplateLangsTable'];
        $this->NotificationTemplateLangs = TableRegistry::get('NotificationTemplateLangs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NotificationTemplateLangs);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
