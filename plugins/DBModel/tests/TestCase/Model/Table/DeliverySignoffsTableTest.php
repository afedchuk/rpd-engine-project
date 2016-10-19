<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DeliverySignoffsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DeliverySignoffsTable Test Case
 */
class DeliverySignoffsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DeliverySignoffsTable
     */
    public $DeliverySignoffs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.delivery_signoffs',
        'app.deliveries',
        'app.notification_templates'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DeliverySignoffs') ? [] : ['className' => 'App\Model\Table\DeliverySignoffsTable'];
        $this->DeliverySignoffs = TableRegistry::get('DeliverySignoffs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DeliverySignoffs);

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
