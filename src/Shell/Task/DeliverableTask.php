<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use DBModel\Model\Table\DeliverablesTable as Deliverable;

/**
 * InitSolid shell task.
 */
class DeliverableTask extends QueueTask
{

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main(array $params = [])
    {
        $lockUid = uniqid(get('engineId'), true);
        if (!$this->Loches->getLock('deliverables', $lockUid, 3, 1, 0)) {
            return false;
        }
        $deliverables = $this
                    ->Deliverables
                    ->find()
                    ->where(['status' => Deliverable::CONSTRUCT])
                    ->order(['status' => 'ASC'])
                    ->first();
        if(!$deliverables){
            $this->Loches->put('deliverables', $lockUid);
            return false;
        }
        set('artifactId', $deliverables->artifact_id);
        $statusList = array_unique($this->Solids->getSolidsRecursively( $deliverables->artifact_id, 'status', [], true));
      
        $resultStatus = $this->Artifacts->filterStatuses($statusList, Deliverable::CONSTRUCT);
        if($resultStatus !== Deliverable::CONSTRUCT){
            $deliverables->status = $resultStatus;
            if(!$this->Deliverables->save($deliverables)){
                $this->Loches->put('deliverables', $lockUid);
                $this->engineAudit("Internal issue. Unable to save into " . get_class($this->Deliverables), [], 'warning');
                return $this->errors();
            }
            $this->feedMe('Instance Construction Completed',[],0,0,'S');
        }

        $this->Loches->put('deliverables', $lockUid);
        remove('artifactId');
        return true;

    }

   

}