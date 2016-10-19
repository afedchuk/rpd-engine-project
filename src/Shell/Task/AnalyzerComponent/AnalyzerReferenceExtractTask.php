<?php
namespace App\Shell\Task\AnalyzerComponent;

use Cake\Console\Shell;

/**
 * AnalyzerReferenceExtract shell task.
 */
class AnalyzerReferenceExtractTask extends AnalyzerReferenceExplodeTask
{

	protected $_defaultConfig = [
				'strip_paths_yn' => 'Strip path from files',
				'match_pattern'  => 'Select pattern (Empty for all files)',
				'new_solid_name' => 'Artifact name to create'
			];

	protected $desciption = 'Explode Reference Selectively';

	protected $version = 10;

	protected $moduleName = 'extractor';

    /**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params, array $bridge) 
    {

    	try {
    		$solid = $this->Solids->get($params['solid_id']);
    		if(isset($params['match_pattern'])) {
		    	$this->feedMe('Extracting artifacts in reference [name] using [pattern]', ['[name]' => $solid['name'], '[pattern]' => $params['match_pattern']], 0, 0, 'O');
		    }
	    	parent::capabilityMain($params, $bridge);
    	} catch(\Exception $e) {
            $this->engineAudit('Internal error artifact configuration entries [name]. '. $e->getMessage(), ['[name]' => $params['analModule']], 'error');
            return -1;
        }
    }

    /**
    * Predefined any additional operations before main process execute.
    * @param array $entry solid record
    * @param array $params entered main properties
    * @return bool | int code execution
    **/
    protected function entryProcess(array &$entry, array $params)
    {
    	// ovveride solid name
    	if(isset($params['new_solid_name']) && $params['new_solid_name']) {
    		$entry['name'] = $params['new_solid_name'];
    	} elseif(isset($params['path']) && basename($params['path'])) {
    		$entry['name'] = basename($params['path']);
    	}

        if (!empty($params['match_pattern'])) {
            if (($matched = @preg_match($params['match_pattern'], $entry['path'])) === false) {
                $this->engineOut('Invalid select expression for analyzer [name]', ['[name]' => $params['analName']], 'error');
                $this->feedMe('The select pattern for the analyzer is invalid.', [], 0, 0, 'E');
                $this->flushSolidCache();
                return 92;
            }
        }
        return true;
    }
}
