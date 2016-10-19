<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DelEnvsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DelEnvsTable Test Case
 */
class DelEnvsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DelEnvsTable
     */
    public $DelEnvs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        'app.del_env_signoffs',
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
        $config = TableRegistry::exists('DelEnvs') ? [] : ['className' => 'App\Model\Table\DelEnvsTable'];
        $this->DelEnvs = TableRegistry::get('DelEnvs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DelEnvs);

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
