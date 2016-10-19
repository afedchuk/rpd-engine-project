<?php
namespace App\Shell\Task\AnalyzerComponent;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use App\Shell\Task\Task\ExecuteAssetTask;

/**
 * AnalyzerReferenceExplode shell task.
 */
class AnalyzerReferenceExplodeTask extends ExecuteAssetTask
{

	protected $_defaultConfig = ['strip_paths_yn' => 'Strip path from files',
								 'delete_solid_yn' => 'Delete source content'];

	protected $desciption = 'Explode Reference';

	protected $version = 15;

    protected $moduleName = 'exploder';

    /**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params, array $bridge) 
    {
        try {
            $solid = $this->Solids->getRecursiveSolidById($params['solid_id']);
            // Extract the solid - 
            if($this->getSolidContent($params['solid_id'], $solid) === false) {
                $this->feedMe('Unable to open reference content from database', [], 0, 0, 'E');
                return 91;
            }

            if(($entry = $this->getSolidEntry($solid['name'], $params['artifact_id'], $solid)) !== false) {
            	$entry['path'] = (isset($params['strip_paths_yn']) && $params['strip_paths_yn'] == 'y' ? basename($entry['path']) : $entry['path']);
                $entry['name'] = str_replace(['/', '\\', ' '], ['.', '.', '_'], $entry['path']);

                if(($code = $this->entryProcess($entry, $params)) !== true) {
                    return $code;
                }

                // create the master solid record
                $master = ['name' => $entry['name'], 
                        'location' => 'artifact://' . $solid['name'] .  '/' . $entry['path'],
                        'store_uri' => $this->getSysPref('artifact_store_uri','db://base64') . "/" . Text::uuid(),
                        'siz' => ($entry['type'] == 'D') ? 0 : $entry['siz'],
                        'bridge_id' => $solid['bridge_id'],
                        'module_name' => $this->moduleName,
                        'toc' => $entry['path'],
                        'content' => $solid['content'],
                        'sequence' => $this->Solids->nextSequence(['artifact_id' => $solid['artifact_id']]),
                        'stamp' => $solid['stamp'],
                        'product_id' => $solid['product_id']
                    ];
                    
                // we'll copy to this solid and do translation, then rec when done
                if(($result = $this->Solids->populateMasterSlaveSolid($master)) !== true) {
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
                 
                if($this->entrySolid($entry, $solid)) {
                    $this->feedMe('Added entry [path]', ['[path]' => $entry['path']], 0, 0, 'T');
                } else {
                    return false;
                }

                // copy any analyzers as needed
				if(!$this->Solids->SolidAnalyzerMaps->copyMap($solid['id'], $slaveId, $params['analSequence'], false, false)) {
                    $this->engineAudit('Unable copy analyzer map solid from [solid] to [new] solid.', [
                            '[solid]' => $solid['id'], '[new]' => $slaveId], 'error');
                }
                
                $this->flushSolidCache();

                // delete the source solid 
                if  ($params['delete_solid_yn'] == 'y') {
                    $entity = $this->Solids->get($solid['id']);
                    $this->Solids->delete($entity);
                }

                // flag the artifact as changed
                $this->artifactTouch($solid);
            }
            return 0;
        } catch(\Exception $e) {
            $this->engineAudit('Internal error exploding reference entry from [name] analyzer. '. $e->getMessage(), ['[name]' => $params['analModule']], 'error');
            return -1;
        }
        return -1;
    }

    /**
    * Write some content to a solid. this ALWAYS appends to the write copy of the archive
    **/
    protected function entrySolid(array $entry, array $solid)
    {
        if (($rc = $this->addToSolid($entry, true, $solid)) === false) {
            $this->engineOut('Unable to store content for [name] in database', ['[name]' => $entry['name']]);
            $this->feedMe('Internal error saving instance data', [], 0, 0, 'E');
            return false;
        }
        return true;
    }

    /**
    * Predefined any additional operations before main process execute.
    * @param array $entry solid record
    * @param array $params entered main properties
    * @return bool | int code execution
    **/
    protected function entryProcess(array &$entry, array $params)
    {
        return true;
    }
}
