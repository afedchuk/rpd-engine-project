<?php
namespace App\Shell\Task\AnalyzerComponent;

use Cake\Console\Shell;
use App\Shell\Task\QueueTask;

/**
 * AnalyzerInstanceConfig shell task.
 */
class AnalyzerInstanceConfigTask extends QueueTask
{
	public $tasks = ['Bridge'];

	protected $_defaultConfig = [
				'host_bridge'		=> 'Bridge To Run Action On',
				'run_action'		=> 'Config Entry Generation Action',
				'cleardups_yesno'	=> 'Remove duplicate entries'
			];

	protected $desciption = 'Add Artifact Configuration Entries';

	protected $version = 6;

	/**
	* Set the remote capability name
	**/
	public function filterRemoteParams(array $params) {
		if(!isset($params['host_bridge'])) {
			$this->feedMe('No Bridge specified for "[name]" analyzer configuration', ['[name]' => $params['analName']], 0, 0,'E');
			return [];
		}

		if(!isset($params['run_action'])) {
			$this->feedMe('No Action specified for "[name]" analyzer configuration', ['[name]' => $params['analName']], 0, 0, 'E');
			return [];
		}

		// map the bridge id to the actual bridge hostname
		$params['hostname'] = $this->Bridges->get($params['host_bridge'])->hostname;
		$params['env']['VL_SOLID_NAME'] = isset($params['solid_name']) ? $params['solid_name'] : '';
		
		// git 'er done....
		$params['cmdArgv'] = array();
		array_push($params['cmdArgv'], $params['run_action']);
		array_push($params['cmdArgv'], $params['env']['VL_SOLID_NAME']);
		return $params;
	}

	/**
	*  Set the remote capability name
	**/
	public function wantRemoteCapability() {
		return 'prun';
	}

	/**
    * Set the search pattern
    **/
	protected static function searchPattern(array &$params)
	{
		if (!isset($params['prop_regex'])) {
			$params['prop_regex'] = '/^\[.*?\].+=.*$/';
		}
	}

    /**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params, array $bridge = []) 
    {
		try {
			$solid = $this->Solids->get($params['solid_id']);
    		$deplist = explode("\n",trim($solid['content']));
    		self::searchPattern($params);

			// process the data
			while ((trim($buf = $this->Bridge->getBridgeResponseBlock($bridge, $params))) !== false) {
				if (is_string($buf)) {
					$this->feedMe($buf, [], 0, 0, 'O');
					if (preg_match($params['prop_regex'], $buf) > 0) {
						$this->feedMe('Configuation Entry: "[line]"', ['[line]' => $buf], 0, 0, 'S');
						array_push($deplist, $buf);
					}
				}
			}

			// delete any empties
			foreach ($deplist as $idx => $value) {
				if (empty($value)) {
					unset($deplist[$idx]);
				}
			}

			// clear any dups in the array
			if ($params['cleardups_yesno'] == 'y') {
				$deplist = array_keys(array_flip($deplist));
			}

			$this->Solids->updateAll(['content' => base64_encode(join("\n",$deplist))], ['id' => $params['solid_id']]);
			$this->artifactTouch($solid);
    		return 0;
		} catch(\Exception $e) {
            $this->engineAudit('Internal error artifact configuration entries [name]. '. $e->getMessage(), ['[name]' => $params['analModule']], 'error');
            return -1;
        }
    	return -1;
    }
}
