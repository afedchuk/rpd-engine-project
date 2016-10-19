<?php
namespace App\Shell\Task\AnalyzerComponent;

use Cake\Console\Shell;
use App\Shell\Task\Analyzer\AnalyzerInstancePropertyTask;

/**
 * AnalyzerReferenceMd shell task.
 */
class AnalyzerReferenceMdTask extends AnalyzerInstancePropertyTask
{
	public $tasks = ['Bridge'];

	protected $_defaultConfig = [
				'host_bridge'		=> 'Bridge To Run Action On',
				'run_action'		=> 'Meta-Data Generation Action'
			];

	protected $desciption = 'Set Artifact Meta-Data';

	protected $version = 3;

	/**
	* Set the remote capability name
	**/
	public function filterRemoteParams(array $params) {
		parent::filterRemoteParams($params);
		
	}

	/**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params, array $bridge) 
    {
    	try {
	    	parent::capabilityMain($params, $bridge);
	    	if (!empty($params['version'])) {
				$this->Solids->updateAll(['stamp'=> $params['version'], 'meta' => trim(join("\n", $params['entries']))], ['id' => $params['solid_id']]);
				unset($params['entries'], $params['version']);
			}
    	} catch(\Exception $e) {
            $this->engineAudit('Internal error of setting artifact meta data for [name] analyzer. '. $e->getMessage(), ['[name]' => $params['analModule']], 'error');
            return -1;
        }
    }

    /**
    * Predefined any additional operations before main process execute.
    * @param array $entry solid record
    * @param array $params entered main properties
    * @return bool | int code execution
    **/
    protected function entryProcess(array &$params, string $buf)
    {
    	$params['entries'] = [];
		if (preg_match('/^(.+?)=(.*)$/',$buf, $matches) > 0) {
			if (strcasecmp($matches[1],"version") == 0) {
				$params['version'] = $matches[2];
				$this->feedMe("Set Version: [value]", ['[value]' => $params['version']], $this->Bridge->getId(), 0, 'T');
			}
			else {
				array_push($params['entries'], $buf);
				$this->feedMe("Set: [meta]", ['[meta]' => $buf],  $this->Bridge->getId(), 0, 'T');
			}
		}
        return true;
    }
}
