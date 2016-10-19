<?php
namespace App\Shell\Task\Task;

use Cake\Console\Shell;
use Cake\Utility\Inflector;
use App\Shell\Task\Task\ExecuteTask; 
/**
 * InitSolid shell task.
 */
class ExecuteEmptyTask extends ExecuteTask
{   
	public function initialize(){}
   /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main(array $data = []) 
    {
        $module = $data['prefix'] . Inflector::classify($data['module']);
        $this->engineAudit("Execution [cap] module", ['[cap]' => $data['module']]);
        $status = ['local' => 0, 'remote' => 0];
        try {
            self::$capability = $this->load($data['prefix'], $module);
            foreach (['initialize', 'preProcess', 'filterRemoteParams', 'wantRemoteCapability', 'capabilityMain'] as $key => $value) {
                if (method_exists(self::$capability, $value)){
                    $this->engineAudit("Running value method of [cap] module", ['[cap]' =>  $module]);
                    $status['local'] = self::$capability->$value($data['params']);
                }
            } 
        } catch(\Exception $e) {
            remove('artifactId');
            $this->engineOut('Unable to install local capability component [capability_name]'. $e->getMessage(), [
                '[capability_name]' => $module]);
        }
        return $status;
    }
}
