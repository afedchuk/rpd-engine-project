<?php
namespace App\Shell\Task\SolidComponent;

use Cake\Console\Shell;
use App\Shell\Task\Task\ExecuteAssetTask;
use DBModel\Model\Table\SolidsTable as Solid;

/**
 * SolidAssetFile shell task.
 */
class SolidAssetFileTask extends ExecuteAssetTask
{
	protected $version = 2;
	public $remoteCapability = 'fileget';

	 /**
	* Set the remote capability name
	**/
	public function filterRemoteParams(array &$params) {
		
		$solid = $this->Solids->get($params['solidId']);
		$parts = [];
		$params = array_merge($params, [
							'location' => $solid->location, 
							'artifact' => $solid->name,
							'hostname' => $this->Bridges->get($solid->bridge_id)->hostname,
							'remote_reference' => $solid->remote_reference
						]
				);
		return  $this->helper('Engine')->parseSolidLocation($params, $parts, true);
	}

    /**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params) 
    {
    	$bridge = get('bridge');

    	$solidInfo = $this->Solids->get($params['solidId'], ['contain' => ['Uris', 'Uris.SolidPatterns']]);
		if (isset($solidInfo->uri->solid_patterns) &&!empty($solidInfo->uri->solid_patterns)) {
			foreach ($solidInfo->uri->solid_patterns as $path) {
				array_push($bridge['receive_patterns'], ['flag' => $path['flag'], 'pattern' => $path['pattern']]);
			}
		}
		
		set('bridge', $bridge);
		while (($buf = $this->Bridge->getBridgeResponseBlock()) !== false) {
			if (is_string($buf)) {
	            $this->feedMe($buf, [], $bridge['id'], 0, 'O', $solidInfo->id);
	        }
		}
		$this->completeInstance($solidInfo->id, $solidInfo->artifact_id, (get('bridge')['status'] == 0 ? Solid::READY : Solid::ERROR));
		return 0;
    }
}
