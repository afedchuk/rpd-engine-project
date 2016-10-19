<?php
namespace App\Shell\Task\AnalyzerComponent;

use Cake\Console\Shell;
use ZipArchive;
use App\Shell\Task\QueueTask;

/**
 * AnalyzerWarfileContent shell task.
 */
class AnalyzerWarfileContentTask extends QueueTask
{
	protected $_defaultConfig = [];

	protected $desciption = 'Expose WAR Contents';

	protected $version = 6;


    public function initialize()
    {
        parent::initialize();
        $this->loadModel('DBModel.Deliverables');
        $this->loadModel('DBModel.Artifacts');
    }
    
    /**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params, array $bridge = []) 
    {
    	try { 
    		$archive = new ZipArchive();
	    	$solid = $this->Solids->getRecursiveSolidById($params['solid_id']); 
	    	$toc = $solid['toc'];
	        if($this->getSolidContent($params['solid_id'], $solid) === false) {
	            $this->feedMe('Unable to open reference content from database', [], 0, 0, 'E');
	            return 91;
	        }
	        $lookFor = '*';
			if(isset($params['analyze'])) {
				$lookFor = $params['analyze'];
			}
			while(($entry = $this->getSolidEntry($solid['name'], $params['artifact_id'], $solid)) !== false) {
				switch($entry['type']) {
					case 'F':
						if(preg_match('/.war$/i', $entry['path'])) {
							$archive->open($entry['content']);
							for($i = 0; $i < $archive->numFiles; $i++) {
								$fileInfo = $archive->statIndex($i);
								if(preg_match(patternToRegex($lookFor), $fileInfo['name'])) {
									$toc.=$entry['path'].'/'.$fileInfo['name']."\n";
								}
							}
							$archive->close();
						}
						break;
					default:
						break;
				}
			}
			
			$this->flushSolidCache();
			$this->Solids->updateAll(['toc' => $toc], ['id' => $params['solid_id']]);
			$this->engineOut('Updated TOC for solid [solid] of instance [deliverable] of [artifact].', [
					'[solid]' => $solid['name'], 
					'[artifact]' => $this->Artifacts->findById($params['artifact_id'])->first()->name,
					'[deliverable]' => $this->Deliverables->findByArtifactId($params['artifact_id'])->first()->name

				]
			);
			$this->feedMe(sprintf("%s <-- Updated table of contents", $params['solid_name']), [], 0, 0, 'T');
			$this->artifactTouch($solid);
	        return 0;
    	} catch(\Exception $e) {
            $this->engineAudit('Internal error of expose WAR contents for [name] analyzer. '. $e->getMessage(), ['[name]' => $params['analModule']], 'error');
            return -1;
        }
        return -1;
    }
}
