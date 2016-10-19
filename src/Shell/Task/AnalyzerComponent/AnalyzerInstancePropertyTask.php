<?php
namespace App\Shell\Task\AnalyzerComponent;

use Cake\Console\Shell;
use App\Shell\Task\Analyzer\AnalyzerInstanceConfigTask;

/**
 * AnalyzerInstanceProperty shell task.
 */
class AnalyzerInstancePropertyTask extends AnalyzerInstanceConfigTask
{

	protected $_defaultConfig = [
				'host_bridge' => 'Bridge To Run Action On',
				'run_action' => 'Property Generation Action'
			];

	protected $desciption = 'Set Artifact Properties';
    
    /**
	* Set the remote capability name
	**/
	public function filterRemoteParams(array $params) {
		return parent::filterRemoteParams($params);
	}



	/**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params, array $bridge = []) 
    {
    	$ignoreLines = false;
    	self::searchPattern($params);
    	try {
			// process the data
			while ((trim($buf = $this->Bridge->getBridgeResponseBlock($bridge, $params))) !== false) {
				if (is_string($buf)) {
					$this->feedMe($buf, [], 0, 0, 'O');
					if (preg_match('/^VL_IGNORE_SETS$/', $buf)) {
						continue;
					}
					$this->entryProcess($params, $buf);
				}
			}
			// store the props received in the instance 
			if(isset($params['vers']) && !empty($params['vers'])) {
				foreach ($params['vers'] as $name => $value) {
					$this->ArtifactProperties->deleteAll(['artifact_id' => $params['artifact_id'], 'name' => $name]);
					$new = $this->ArtifactProperties->newEntity([
											'artifact_id' => $params['artifact_id'],
											'name' => $name,
											'value' => $value
										]
									);
					if(!$this->ArtifactProperties->save($new)) {
						$this->engineAudit('Unable to save artifact properties for [[solid]] solid.', [
										'[solid]' => $params['solid_id'],
										'errors' => $new->errors(),
									], 'error');
					}
					$this->feedMe('Set property: "[name]=[value]"', ['[name]' => $name, '[value]' => $value], 0, 0, 'T');
				}
				unset($params['vers']);
				$this->artifactTouch($solid);
			}
			return 0;
		} catch(\Exception $e) {
            $this->engineAudit('Internal error of setting artifact properties for [name] analyzer. '. $e->getMessage(), ['[name]' => $params['analModule']], 'error');
            return -1;
        }
        return -1;
    }

    /**
    * Predefined any additional operations before main process execute.
    * @param array $params entered main properties
    * @param string $buf bridge buffer
    * @return void
    **/
    protected function entryProcess(array &$params, string $buf)
    {
    	if (preg_match($params['prop_regex'], $buf, $matches) > 0) {
			if (empty($matches[1])) {
				$this->feedMe('Property name is empty: [line]', ['[line]' => $buf], 0, 0, 'E');
			} else {
				$name = $matches[1];
				if (empty($matches[2])) {
					$matches[2] = '';
				}
				$value = $matches[2];
				$params['vers'][$name] = $value;
			}
		}
    }
}
