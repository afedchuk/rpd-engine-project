<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * Analyzer shell task.
 */
class AnalyzerTask extends QueueTask
{
    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main(array &$params = [])
    {
        // The solid id we get is that of the reference, as that is what is usually going to be interacted with.
        // All master solids should have their analyze flag set to 'n' or just not 'y'.
        $lockUid = uniqid(get('engineId'),true);
        if($this->Loches->getLock('analyzers', $lockUid, 3, 1, 0) !== true) {
            return false;
        }

        if(($solid = $this->getSolidForAnalysis($this->Bridges->getZoneServerList())) === null) {
           $this->Loches->put('analyzers', $lockUid);
           return false;
        } else {
            set('artifactId', $solid->artifact_id); 
            $this->Solids->updateAll(['engine_id' => get('engineId')], ['id' => $solid->id]);
        	if(($results = $this->SolidAnalyzerMaps->analyzeContent($solid->toArray(), get('eventId')))) {
                $this->Solids->setSolidStatus($solid->id, 0, 'Processing');
                foreach ($results as $key => $value) {
                    if(isset($value->analyzer->info_module->name)) { 
                        try { 
                            $returnParams = $params;
                            $this->analyzerProperty($value->analyzer, $returnParams);
                            $returnParams = array_merge($returnParams, [
                                    'solid_id' => $solid->id, 'analName' => $value->analyzer->name,
                                    'analModule' => $value->analyzer->info_module['name'], 'analSequence' => $value->sequence
                                ]);
                            $this->artifactProperty($returnParams); 
                            return ['params' => $returnParams, 'module' => $value->analyzer->info_module->name, 'prefix' => 'Analyzer'];
                        } catch(\Exception $e) {
                            $this->engineOut('Unable to load local analyzer component [capability_name]', [
                                '[capability_name]' => $value->analyzer->info_module->name]);
                            return false;
                        }
                    } else {
                        $this->Solids->setSolidStatus($solid->id, 100, 'Error');
                        return false;
                        }
                }
        	} else {
                return false;
            }

        }
        return true;
    }

    /**
     * Getting artifact properties for task component
     * @param array $params properties storage
     * @return void
    **/
    private function artifactProperty(array &$params)
    {
        if(get('artifactId') > 0) {
            $properties = $this->ArtifactProperties->find('all')->where(['artifact_id' => get('artifactId')])->toArray();
            if(!empty($properties)) {
                foreach($properties as $key => $property) {
                    $params['env'][$property['name']] = $property['value'];
                }
            }
        }
    }

    /**
     * Getting analyzer properties for task component
     * @param object \DBModel\Model\Entity\Analyzer  The analyzer object
     * @param array $params properties storage
     * @return void
    **/
    private function analyzerProperty(\DBModel\Model\Entity\Analyzer  $analyzer, array &$params)
    {
        if($analyzer->analyzer_properties != null) {
            foreach($analyzer->analyzer_properties as $key => $property) {
                $params[$property['name']] = $property['value'];
            }
        }
    }

    /**
     * Looking for solid for analyzing
     * @param array $validBridges available servers
     * @return bool false| int solid id
    **/
    private function getSolidForAnalysis(array $validBridges = [])
    {
        return $this->Solids->find()
            ->where(['artifact_id >' => '0', 'gmt_fetched >' => 1,  'analyz' => 'y', 'status !=' => 'Error', 'engine_id' => 0, 'bridge_id IN' => $validBridges])
            ->contain([])
            ->first();
    }
}
