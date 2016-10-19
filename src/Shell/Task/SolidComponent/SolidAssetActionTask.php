<?php
namespace App\Shell\Task\SolidComponent;

use Cake\Console\Shell;
use App\Shell\Task\Task\ExecuteAssetTask;
use DBModel\Model\Table\SolidsTable as Solid;

/**
 * SolidAssetAction shell task.
 */
class SolidAssetActionTask extends ExecuteAssetTask
{
	protected $version = 2;
	public $remoteCapability = 'srun';

	 /**
	* Set the remote capability name
	**/
	public function filterRemoteParams(array &$params) {

		$solid = $this->Solids->get($params['solidId'], ['contain' => ['Uris']]);
		$parts = [];
		$params = array_merge($params, [
							'location' => $solid->location, 
							'artifact' => '',
							'hostname' => $this->Bridges->get($solid->bridge_id)->hostname,
							'remote_reference' => $solid->remote_reference
						]
				);
		$params = $this->helper('Engine')->parseSolidLocation($params, $parts, true);
		if (empty($params['action']) && empty($parts['host'])) {
			return(false);
		}
		
		if (empty($params['action'])) {
			$params['cmdArgv'] = array($parts['host']);
		} else {
			$params['cmdArgv'] = array($params['action']);
		}

		foreach ($parts as $key => $value) {
			$var = "VL_URI_" . strtoupper($key);
            if (isset($params['env']['VL_IGNORE_VARIABLE_IN_PATH']) &&
                      $params['env']['VL_IGNORE_VARIABLE_IN_PATH'] == true) {
               $params['env'][$var] = "'". $value . "'";
            } else {
               $params['env'][$var] = $value;
            }
		}
		$params['env']['VL_POST_ARTIFACT'] = $solid->name;
		
		return($params);
	}

    /**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params) 
    {
    	$solid = $this->Solids->get($params['solidId'], ['contain' => ['Uris']]);
    	if (empty($params['match_pattern'])) {
			$params['match_pattern'] = '/^(\[.*])(\w+)=(.*)$/';
		} else {
			if (@preg_match($params['match_pattern'],"xxx") === false) {
				$this->feedMe('Invalid resource match pattern [pat]', ['[pat]' => $params['match_pattern']], 0,0,'E', $bridge['solidId']);
				return(-701);
			}
		}
		
		$processed = 0;
		$bridge = get('bridge');
		$solidId = get('solidId');
		$bridge['scriptName'] = $solid->uri->module_name;
		set('bridge', $bridge);
		while (($buf = $this->Bridge->getBridgeResponseBlock()) !== false) {
            if (is_string($buf)) {
				$this->feedMe($buf,[], $bridge['id'], 0 ,'O', $solidId);
			}
		}
		$this->completeInstance($solidId, get('artifactId'), (get('bridge')['status'] == 0 ? Solid::READY : Solid::ERROR));
		return 0;
    }
}
