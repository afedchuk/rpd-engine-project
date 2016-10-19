<?php
namespace App\Shell\Task\AnalyzerComponent;

use Cake\Console\Shell;
use Cake\Network\Http\Client;
use App\Shell\Task\QueueTask;

/**
 * AnalyzerRpmVersionTag shell task.
 */
class AnalyzerRpmVersionTagTask extends QueueTask
{

	protected $_defaultConfig = [
				'rpm_server_url'		=> 'RPM Server URL',
				'rpm_user_token'		=> 'RPM User Token',
				'rpm_find_application'	=> 'Application',
				'rpm_find_component'	=> 'Component',
				'rpm_find_environment'	=> 'Environment'
			];

	protected $desciption = 'RPM Version Tag';

	protected $version = 1;

	public function initialize()
    {
        parent::initialize();
        $this->loadModel('DBModel.Deliverables');
    }

	/**
	* Set the remote capability name
	**/
	public function filterRemoteParams(array $params) {
		if (empty($params['rpm_server_url'])) {
			$this->feedMe('No RPM server specified for analyzer configuration [name]', ['[name]' => $params['analName']], 0, 0, 'E');
			return(array());
		}

		if (empty($params['rpm_user_token'])) {
			$this->feedMe('No RPM user token specified for analyzer configuration [name]', ['[name]' => $params['analName']], 0, 0, 'E');
			return(array());
		}
		return($params);
	}

    /**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params, array $bridge = []) 
    {
    	foreach($this->_defaultConfig as $key => $value) {
			if(isset($params['env'][$key])) {
				$params[$key] = $params['env'][$key];
			}
		}

		try { 
			$tagName =$this->Deliverables->findByArtifactId($params['artifact_id'])->first();
			if($tagName !== null) {
				$fields = json_encode([
							'find_application' => urlencode($params['rpm_find_application']),
							'find_component' => urlencode($params['rpm_find_component']),
							'find_environment' => urlencode($params['rpm_find_environment']),
							'name' => urlencode($tagName->name)
						]
					);
				$http = new Client();
				$response = $http->post($params['rpm_server_url'].'/v1/version_tags?token='.$params['rpm_user_token'], $fields, ['type' => 'json']);
				if(isset($response->json) && !empty($response->json)) {
					if(isset($response->json['app_id']) && $response->json['app_id']) {
						$this->feedMe('RPM version TAG [name] has been created', ['[name]' => $$response->json['name']], 0, 0, 'T');
					} else {
						foreach($response->json as $key => $value) {
							foreach ($value as $msg) {
								$this->feedMe('RPM version tag could not create, ' .$key. ' '.$msg, [], 0, 0, 'E');
							}
						}
						
					}
				} else {
					$this->feedMe('Could not connect to RPM server, check analyzer configurations.', [], 0, 0, 'E');
				}
			} else {
				throw new \Exception("Could not found artifact item in deliverable table.", 1);
			}
			return 0;
		} catch(\Exception $e) {
            $this->engineAudit('Internal error of getting RPM version tag for [name] analyzer. '. $e->getMessage(), ['[name]' => $params['analModule']], 'error');
            return -1;
        }
        return -1;
    }
}
