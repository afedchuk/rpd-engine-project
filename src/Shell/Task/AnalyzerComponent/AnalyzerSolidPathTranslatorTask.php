<?php
namespace App\Shell\AnalyzerComponent;

use Cake\Console\Shell;
use App\Shell\Task\Analyzer\AnalyzerReferenceExplodeTask;

/**
 * AnalyzerSolidPathTranslator shell task.
 */
class AnalyzerSolidPathTranslatorTask extends AnalyzerReferenceExplodeTask
{
	protected $_defaultConfig = [
				'a_search_for'	 => 'Search For',
				'b_replace_with' => 'Replace With',
				'del_non_matches_yn' => 'Delete Non-Matching Entries',
				'delete_solid_yn' => 'Delete source content'
			];

	protected $desciption = 'Translate Path';

	protected $version = 16;

	/**
	* Set the remote capability name
	**/
	public function filterRemoteParams(array $params) {
		if (empty($params['del_non_matches_yn'])) {
			$params['del_non_matches_yn'] = 'n';
		}
		if (empty($params['b_replace_with']))
				$params['b_replace_with'] = '';
		return $params;
	}
    /**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params, array $bridge = []) 
    {
    	try { 
	    	if (@preg_match($params['a_search_for'],"test string") === false) {
				$this->feedMe('Property match expression is invalid: [regex]', ['[regex]' => $params['a_search_for']],0,0,'E');
				return -937;
			}
			$solid = $this->Solids->getRecursiveSolidById($params['solid_id']);
            if($this->getSolidContent($params['solid_id'], $solid) === false) {
                $this->feedMe('Unable to open reference content from database', [], 0, 0, 'E');
                return 91;
            }
            $this->feedMe('Translating artifact paths in reference [name]',['[name]' => $solid['name']], 0, 0, 'O');

            // create the new master solid record
			$master = $solid;
			unset($master['id']);
            $master = array_merge($master, [
            		'name' => $solid['name']. getmypid(), 
                    'analyz' => 'n',
                    'reference_id' => 0,
                    'gmt_fetched' => 0,
                    'engine_id' => 0,
                    'status' => 'Processing'
                ]
            );

            // we'll copy to this solid and do translation, then rename when done
            if(($result = $this->Solids->populateMasterSlaveSolid($master, false)) !== true) {
            	$this->engineAudit('Unable to save master/slave [solid] solid.', [
                                	'[solid]' => $master['name'], 'errors' => $result], 'error');
            	return -1;
            } else {
            	$slaveId = $this->Solids->getInsertID();
            	if(($depends = $this->SolidDepends->populateMasterSlaveSolidDepend($slaveId, $solid['id'])) !== true) {
        			$this->engineAudit('Unable duplicate the explodees dependencies for master/slave [[solid]] solid.', [
                                '[solid]' => $master['name'], 
                                'errors' => $depends], 'error');
                    return -1;
            	}
            }

            // copy any analyzers as needed
			if(!$this->Solids->SolidAnalyzerMaps->copyMap($solid['id'], $slaveId, $params['analSequence'], true, false)) {
                $this->engineAudit('Unable copy analyzer map solid from [solid] to [new] solid.', [
                        '[solid]' => $solid['id'], '[new]' => $slaveId], 'error');
            }

            if(($entry = $this->getSolidEntry($solid['name'], $params['artifact_id'], $solid)) !== false) {
            	$old = $entry['path'];
            	if (($new = @preg_replace($params['a_search_for'], $params['b_replace_with'] ,$entry['path'])) == null) {
					$this->feedMe('Error during string translation replacing "[srch]" with "[repl]" on "[str]"', [
										'[srch]' => $params['a_search_for'], 
										'[repl]' => $params['b_replace_with'], 
										'[str]' => $entry['path']
									], 0, 0, 'E');
            	} else {
					if ($new != $old) {
						$entry['path'] = $new;
						$this->feedMe('"[old]" --> "[new]"', [
								'[old]' => $old, 
								'[new]' => $new
							], 0, 0, 'T');
					} else if (!empty($params['del_non_matches_yn']) && $params['del_non_matches_yn'] != 'n') {
						$this->feedMe("Non-Matching entry [old] deleted", ['[old]' => $old], 0, 0, 'S');
						return -1;
					}
				}

            	$entry['name'] = $master['name'];
            	if(!$this->entrySolid($entry, $solid)) {
                    return -87;
                } 
            }

            $this->flushSolidCache();

			// delete the source solid 
            if($params['delete_solid_yn'] == 'y') {
                $entity = $this->Solids->get($solid['id']);
                $this->Solids->delete($entity);
            }
            $this->Solids->updateAll(['name' => $name, 'analyz' => 'y'], ['id' => $slaveId]);
            $this->Solids->updateAll(['name' => $name], ['id' => $result]);
			$this->artifactTouch($solid);
			return 0;
		} catch(\Exception $e) {
            $this->engineAudit('Internal error of translating solid path for [name] analyzer. '. $e->getMessage(), ['[name]' => $params['analModule']], 'error');
            return -1;
        }
		return -1;
    }
}
