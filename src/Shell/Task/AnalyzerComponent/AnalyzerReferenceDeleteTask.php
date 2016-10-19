<?php
namespace App\Shell\Task\AnalyzerComponent;

use Cake\Console\Shell;
use App\Shell\Task\QueueTask;

/**
 * AnalyzerReferenceDelete shell task.
 */
class AnalyzerReferenceDeleteTask extends QueueTask
{
	protected $desciption = 'Delete Reference';

	protected $version = 3;
    /**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params, array $bridge) 
    {
    	try {
    		if(isset($params['solid_id'])) {
				$solid = $this->Solids->get($params['solid_id']);
				$this->feedMe('Deleting reference entry [name]', ['[name]' => $solid['name']], 0, 0,'S');
				if($this->Solids->delete($solid)) {
					$this->ArtifactFeeds->deleteAll(['solid_id' => $solid['id']]);
					$this->artifactTouch($solid);
				}
				$this->completeInstance(0, $solid->artifact_id, 'Ready');
				return 0;
			}
		} catch(\Exception $e) {
            $this->engineAudit('Internal error deleting reference entry [name]. '. $e->getMessage(), ['[name]' => $params['analModule']], 'error');
            $this->completeInstance($solid->id, $solid->artifact_id, 'Error');
            return -1;
        }
	    return -1;
    }
}
