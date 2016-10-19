<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DelEnvSignoffsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DelEnvSignoffsTable Test Case
 */
class DelEnvSignoffsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DelEnvSignoffsTable
     */
    public $DelEnvSignoffs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.del_env_signoffs',
        'app.del_envs',
        'app.notification_templates',
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
        'app.del_routes',
        'app.delivery_previews',
        'app.spin_previews'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DelEnvSignoffs') ? [] : ['className' => 'App\Model\Table\DelEnvSignoffsTable'];
        $this->DelEnvSignoffs = TableRegistry::get('DelEnvSignoffs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DelEnvSignoffs);

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
