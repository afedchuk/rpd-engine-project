<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * App Model
 *
 * @property \Cake\ORM\Association\HasMany $AccessPaths
 */
class AppTable extends Table
{
    protected $consistency =  ['conditions' => [['engine_id !=' => 0 ]], 'data' => ['engine_id' => 0]];
	/**
     * Increments counter of the revision
     *
     * @param int $id ID of the Asset
     * @return Cake\Database\Statement\PDOStatement $updResult result of the update statement
     */

    public function incrementRev($id) {

        $updResult = $this->query()
                ->update()
                ->set(['nextrev' => $this->findById($id)->first()->nextrev + 1 ])
                ->where(['id' => $id])
                ->execute();

        return $updResult;
    }

    /**
     * Get latest inserted in table (specific of different dbs)
     *
     * @return int id
    */
    public function getInsertID() {
        return $this->find()->select(['id'])->order(['id' => 'desc'])->first()->toArray()['id'];
    }

    /**
     * Get sequence by artifact id
     *
     * @param  array $conditions table conditions
     * @return int sequence
     */
    public function nextSequence(array $conditions) {
        if(($result = $this->find('all', ['order' => ['sequence' => 'DESC']])
            ->select(['sequence'])
            ->where($conditions)
            ->first()) !== null) {
            return $result['sequence'] + 1;
        }
        return 1;
    }

    /**
     * Consistency check for tasks
     *
     * @param array $ids items ids that found
     * @return bool
     */
    public function consistencyCheck(array &$ids = [])
    {
        foreach($this->consistency['conditions'] as $condition) {
            $items = $this->find('all')->where($condition)
                ->contain((isset($this->consistency['contain']) ? [] : ['Engines']))
                ->toArray();
            if(!empty($items)) {
                foreach ($items as $key => $value) {
                    if(!isset($value->engine->id)) {
                        $item = $this->get($value->id); 
                        if(isset($this->consistency['data']) && !empty($this->consistency['data'])) {
                            $this->patchEntity($item, $this->consistency['data']);
                            if(!$this->save($item)) {
                                return $item->errors();
                            } else {
                                $this->consistencyHook($value);
                                $ids[$this->alias()][] = $value->id;
                            }
                        }
                    }
                }
            }
        }
        return true;
    }
    
    /**
     * Updates the flag field
     *
     * @param int $id Record ID
     * @param string $newFlag new statement
     * @param array $flags set of flags
     * @param string $active status in value of ACTIVE
     * @return bool
     */
    public function setFlag(int $id, string $newFlag, array $flags = [], string $active = "ACTIVE")
    {   
        try {
            $entity = $this->get($id);
            if (in_array($newFlag, $flags)) {
                if ($newFlag == $active) {
                    $entity->gmt_start = time();
                }
                $entity->duration = time() - $entity->gmt_start;
            }
            $entity->flag = $newFlag;
            if (!$this->save($entity)) {
                return $entity->errors();
            }
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Checks the flag
     *
     * @param string $status flag of an appropriate model
     * @param array $flags set of flags
     * @return bool
     */
    public function busy(string $status, array $flags)
    {
        return in_array($status, $flags) ? false : true;
    }

    /**
     * Get model properties for server
     *
     * @param array $params container for properties
     * @param array $conditions model conditions
     * @return void
     */
    public function properties(array &$params = [], array $conditions = [])
    {
        $properties = $this->find('all')
            ->where($conditions)
            ->toArray();

        if(!empty($properties)) {
            foreach ($properties as $value) {
                $params['env'][$value['name']] = $value['value'];
            }
        }
    }


    /**
     * Deletes all Asset data that exist in shedules.
     *
     * @param Cake\Datasource\EntityInterface $entity entity about to be deleted
     * @return bool
     */


    function deleteSchedsData(EntityInterface $entity) {

        $savedScheds = $this->SchedProperties->find('list', ['conditions' => ['SchedProperty.value' => $entity->id, 'SchedProperty.name' => 'deploy_package'], 'fields' => ['SchedProperty.sched_id'] ]);
        $updResult = $this->SchedProperties->updateAll( ['SchedProperties.value' => null ], ['SchedProperties.name' => 'deploy_package', 'SchedProperties.sched_id IN ' => $savedScheds] );
        $optsDelResult = $this->SchedSelectedOptions->deleteAll( ['sched_id IN' => $savedScheds, 'type' => 'uri' ]);
        $propsDelResult = $this->SchedUriAssetProps->deleteAll( ['sched_id IN' => $savedScheds] );
        
        if($updResult && $optsDelResult && $propsDelResult){
            return true;
        }
        return false;
    }

    /**
    * Get a system setting from the prefs database.
    * @param string $name name property
    * @param string $default default value
    * @return string property value
    **/
    public function getSysPref(string $name, string $default = '') {
        $this->Prefs = TableRegistry::get('Prefs', ['className' => 'DBModel\Model\Table\PrefsTable']);
        return $this->Prefs->getPreference($name, 1, $default);
    }

     /**
    * returns correspondent name for actions.
    * @param obj $deliverydelivery object
    * @return string 
    **/ 
    public function renderDelivery($delivery)
    {
        $type = isset($delivery->type) ? $delivery->type : 'D';
        $action = isset($delivery->action) ? $delivery->action : 'go';
        $typeHash = array(
            'D' => array(
                'go' => 'Deploy',
                'goback' =>'Remove'
            ),
            'B' => array(
                'go' => 'Build',
                'goback' =>'Cleanup'
            )
        );
        return($typeHash[$type][$action]);
    }

    /**
    * Get a given field for the model
    * @param string $field field to be fetched
    * @param array $conditions conditions for fields to be fetched
    * @return string | bool
    **/

    public function field(string $field , array $conditions )
    {
        $result = $this->find('all', ['conditions' => $conditions])->first();

        if(isset($result->{$field})){
            return $result->{$field};
        }else{
            return false;
        }
    }
     /**
    * Save a given field for the model
    * @param string $field field to be fetched
    * @param array $conditions conditions for fields to be fetched
    * @return bool
    **/

    public function saveField($conditions, $modelId)
    {
        try{
            $entity = $this->get($modelId);
            $this->patchEntity($entity, $conditions);
            if(!$this->save($entity)){
                return false;
            }
        }catch(\Exception $e){
            return false;
        }
        return true;
    }
 


}
