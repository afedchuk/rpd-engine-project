<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * InitSolid shell task.
 */
class SolidTask extends QueueTask
{

    public $tasks = ['SolidAssetNull'];
    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main(array $params = [])
    {
        $lockUid = uniqid(get('engineId'), true);
        if( !$this->Loches->getLock('solids', $lockUid, 3, 1, 0) ){
            return false;
        }
        $validServersList = $this->Bridges->getZoneServerList();
        $conditions = [
                        'engine_id' => 0, 
                        'artifact_id >' => 0, 
                        'gmt_fetched <=' => 1, 
                        'status' => 'Queued']; // conditions to get all solids independet from zone
        $query = $this
                    ->Solids
                    ->find()
                    ->contain(['Uris'])
                    ->where($conditions)
                    ->matching('Uris', function($q) use ($validServersList) {
                        return ($q->where(['Uris.bridge_id IN' => $validServersList]));
                    }); // find only solids that are in my zone.
        $solids = $query->first();
        if(empty($solids)){ //if solids are empty
            $this->Loches->put('solids', $lockUid);
            return false;  //exit. Nothing to process
        }
        set('artifactId', $solids->artifact_id); // I do not like this way of working with artifact ids
        $solids = $this->Solids->updateSolid($solids->id);
        if($solids === false){
            $this->engineOut("Couldnot assign Engine (ID: [engineId]) for empty solid (name [name] - ID [id] )", [
                '[engineId]' => get('engineId'),
                '[name]' => $solids->name,
                '[id]' => $solids->id]);
            $this->Loches->put('solids', $lockUid);
        }
        $this->populate($solids->id);
        if( $this->Solids->hasInstanceSolidsAnyAnalyzers($solids->artifact_id) ) { // if we have no analyzers set artifact->status, else - let analyzers do their job
            $this->SolidAnalyzerMaps->addSolidToAnalyzer($solids->id);
        }
        $this->Loches->put('solids', $lockUid);
        $result = array('params' => array('solidId' => $solids->id, 'artifactId' => $solids->artifact_id, 'solid' => $solids), 'module' => $solids->uri->remote ? 'asset_remote_reference' : $solids->module_name ,  'prefix' => 'Solid');
        return $result;
    }

    /**
     * populate() method. Populates solids reguardless of a zone.
     * @param int $solidId current solid id
     * @return bool|array Success or error message.
     */
    private function populate(int $solidId) 
    {
        $solid = $this->Solids->get($solidId, ['contain'=>'Uris']); // refetch our solid as DB state had changed.                                                    
        $this->engineOut("Engine [engine_id] accepted population of content [content] for artifact [artifact].", array(
            '[engine_id]' => get('engineId'),
            '[content]' => $solid->name,
            '[artifact]' => $this->Artifacts->findById($solid->artifact_id)->first()->name,
                )
        );
        $solid->engine_id = get('engineId');
        $res = $this->Solids->save($solid);
        if(!$res){
            return $solid->errors();
        }
        $populatedSolid = $this->Solids->populateSolid($solid->id);
        $this->feedMe('Instance Construction Started',[],0,0,'S', $solid->id);
        $this->Artifacts->setArtifactAndDeliverableStatus($solid->artifact_id); // update deliverable and artfifact status when ready
        return true;
    }    

}
