<?php
namespace DBModel\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DBModel\Model\Table\ScriptsTable;

/**
 * DBModel\Model\Table\ScriptsTable Test Case
 */
class ScriptsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \DBModel\Model\Table\ScriptsTable
     */
    public $Scripts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.d_b_model.scripts',
        'plugin.d_b_model.bridges',
        'plugin.d_b_model.platforms',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Scripts') ? [] : ['className' => 'DBModel\Model\Table\ScriptsTable'];
        $this->Scripts = TableRegistry::get('Scripts', $config);
    }

    /**
     * getCorrectData method
     *
     * @return array
     */
    private function getCorrectData()
    {
        $data = [
            'reference_id' => 0,
            'platform_id' => 0,
            'gmt_created' => 1471530507,
            'version' => 0,
            'activ' => 'Y',
            'name' => 'EC2_release_fail',
            'pack_id' => 1,
            'md5' => '0b7e71e1ca7d9b41240625048d825ceb',
            'content' => '#!/bin/bash'               
        ];
        return $data;
    }

    /**
     * Test validationDefault method. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultCorrect()
    {   
        $data = $this->getCorrectData();
        $script = $this->Scripts->newEntity($data);
        $this->assertEmpty($script->errors());
    }

    /**
     * Test validationDefault method if any fields are empty. Expecting correct result.
     *
     * @return void
     */
    public function testValidationDefaultNoAnyFields()
    {
        $data = $this->getCorrectData();
        unset($data['reference_id']);
        unset($data['platform_id']);
        unset($data['gmt_created']);
        unset($data['version']);
        unset($data['activ']);
        unset($data['name']);
        unset($data['pack_id']);
        unset($data['md5']);
        unset($data['content']);
        $script = $this->Scripts->newEntity($data);
        $this->assertEmpty($script->errors());
    }

    /**
     * Test getScriptForBridge method.
     *
     * @return void
     */
    public function testGetScriptForBridge()
    {
        $scriptName = 'EC2_release_fail';
        $bridgeId = 1;
        $result = $this->Scripts->getScriptForBridge($scriptName, $bridgeId);
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('platform', $result);
        $this->assertInstanceOf('DBModel\Model\Entity\Platform', $result['platform']);
    }

    /**
     * Test getScriptForBridge method if no bridge.
     *
     * @return void
     */
    public function testGetScriptForBridgeNoBridge()
    {
        $scriptName = 'EC2_release_fail';
        $bridgeId = 500;
        $result = $this->Scripts->getScriptForBridge($scriptName, $bridgeId);
        $this->assertFalse($result);
    }
}
