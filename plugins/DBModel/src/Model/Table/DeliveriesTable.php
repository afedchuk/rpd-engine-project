<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Console\Shell;
use DBModel\Model\Table\DeliverablesTable as Deliverable;

/**
 * Deliveries Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Deliverables
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $DelEnvs
 * @property \Cake\ORM\Association\BelongsTo $Deliveries
 * @property \Cake\ORM\Association\BelongsTo $PreProcesses
 * @property \Cake\ORM\Association\BelongsTo $PostProcesses
 * @property \Cake\ORM\Association\BelongsTo $VmProcesses
 * @property \Cake\ORM\Association\BelongsTo $Engines
 * @property \Cake\ORM\Association\BelongsTo $ActivePools
 * @property \Cake\ORM\Association\HasMany $DelEnvs
 * @property \Cake\ORM\Association\HasMany $Deliverables
 * @property \Cake\ORM\Association\HasMany $Deliveries
 * @property \Cake\ORM\Association\HasMany $DeliveryChannels
 * @property \Cake\ORM\Association\HasMany $DeliveryProcesses
 * @property \Cake\ORM\Association\HasMany $DeliveryProperties
 * @property \Cake\ORM\Association\HasMany $DeliveryRoles
 * @property \Cake\ORM\Association\HasMany $DeliverySignoffs
 * @property \Cake\ORM\Association\HasMany $Solids
 *
 * @method \DBModel\Model\Entity\Delivery get($primaryKey, $options = [])
 * @method \DBModel\Model\Entity\Delivery newEntity($data = null, array $options = [])
 * @method \DBModel\Model\Entity\Delivery[] newEntities(array $data, array $options = [])
 * @method \DBModel\Model\Entity\Delivery|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DBModel\Model\Entity\Delivery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \DBModel\Model\Entity\Delivery[] patchEntities($entities, array $data, array $options = [])
 * @method \DBModel\Model\Entity\Delivery findOrCreate($search, callable $callback = null)
 */
class DeliveriesTable extends AppTable
{
    const PASS = 'pass';
    const PROCESSING = 'processing';
    const FAIL = 'fail';
    const QUEUE = 'queue';
    const CONFIG = 'config';
    const CANCELLED = 'cancelled';
    const REJECTED = 'rejected';
	const INIT = 'init';
    const SIGNOFF = 'signoff';
    const DELIVER = 'deliver';
    const UNDELIVER = 'undeliver';
    const POST = 'post';
    const VM = 'vm';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('deliveries');
        $this->displayField('id');
        $this->primaryKey('id');
		
		$this->Loches = TableRegistry::get('DBModel.Loches'); 
        $this->DelEnvSignoffs = TableRegistry::get('DBModel.DelEnvSignoffs');
        $this->NotificationTemplates = TableRegistry::get('DBModel.NotificationTemplates');
        $this->Usrs = TableRegistry::get('DBModel.Usrs');
        
        $this->task = (new Shell())->Tasks->load('Queue');

        $this->belongsTo('Deliverables', [
            'foreignKey' => 'deliverable_id',
            'className' => 'DBModel.Deliverables'
        ]);
        $this->belongsTo('Usrs', [
            'foreignKey' => 'user_id',
            'className' => 'DBModel.Usrs'
        ]);
        $this->belongsTo('DelEnvs', [
            'foreignKey' => 'del_env_id',
            'className' => 'DBModel.DelEnvs'
        ]);

        $this->belongsTo('PreProcesses', [
            'foreignKey' => 'pre_process_id',
            'className' => 'DBModel.Processes'
        ]);
        $this->belongsTo('PostProcesses', [
            'foreignKey' => 'post_process_id',
            'className' => 'DBModel.Processes'
        ]);
        $this->belongsTo('VmProcesses', [
            'foreignKey' => 'vm_process_id',
            'className' => 'DBModel.Processes'
        ]);
        $this->belongsTo('Engines', [
            'foreignKey' => 'engine_id',
            'className' => 'DBModel.Engines'
        ]);
        $this->hasMany('DeliveryChannels', [
            'foreignKey' => 'delivery_id',
            'className' => 'DBModel.DeliveryChannels'
        ]);
        $this->hasMany('DeliveryProcesses', [
            'foreignKey' => 'delivery_id',
            'className' => 'DBModel.DeliveryProcesses'
        ]);
        $this->hasMany('DeliveryProperties', [
            'foreignKey' => 'delivery_id',
            'className' => 'DBModel.DeliveryProperties'
        ]);
        $this->hasMany('DeliveryRoles', [
            'foreignKey' => 'delivery_id',
            'className' => 'DBModel.DeliveryRoles'
        ]);
        $this->hasMany('DeliverySignoffs', [
            'foreignKey' => 'delivery_id',
            'className' => 'DBModel.DeliverySignoffs'
        ]);
        $this->hasMany('Solids', [
            'foreignKey' => 'delivery_id',
            'className' => 'DBModel.Solids'
        ]);

        $this->addBehavior('DBModel.QTimestamp', [
            'field' => 'gmt_start',
            ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('type');

        $validator
            ->allowEmpty('action');

        $validator
            ->integer('gmt_created')
            ->allowEmpty('gmt_created');

        $validator
            ->allowEmpty('status');

        $validator
            ->allowEmpty('pause_after');

        $validator
            ->integer('gmt_start')
            ->allowEmpty('gmt_start');

        $validator
            ->integer('duration')
            ->allowEmpty('duration');

        $validator
            ->allowEmpty('target_pool');

        $validator
            ->integer('drift_execs_failure')
            ->allowEmpty('drift_execs_failure');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        return $rules;
    }

    /**
     * Unsigned devileries from engine
     *
     * @param array $items process data.
     * @return bool
     */
    public function engineClean(array $items)
    { 
        foreach ($items as $key => $value) {
            $delivery = $this->get($value->id); 
            $this->patchEntity($delivery, [ 'engine_id' => 0]);
            if(!$this->save($delivery)) {
                return $delivery->errors();
            }
        }
        return true;
    }
	
	 /**
     * Sets engine_id to 0 for delivery
     *
     * @param int $deliveryId Delivery ID
     * @return bool
     */
	
	 public function freeDelivery(int $deliveryId)
    {
        if(!$this->updateAll( ['engine_id' => 0 ], ['id' => $deliveryId ] )) {
			return false;
		}
		return true;
    }
	
	/**
     * Lock the delivery
     *
     * @param int $deliverableId Deliverable ID
	 * @param int $delEnvId Del Env ID
     * @return bool
     */

    public function envLock(int $deliverableId, int $delEnvId) {
        $locking = $this->DelEnvs->field('protected', ['id' => $delEnvId] );

        // To override locking to always obey env flag, remove following four lines.
        if(!$locking) {
            return true;
        }            
        if($this->Deliverables->field('locked', ['id' => $deliverableId ] ) ) {
            return true;
        }        
        $envName = $this->DelEnvs->field('name', ['id' => $delEnvId ]);
        $this->Deliverables->saveField(['locked' => $locking], $deliverableId);
        $this->Deliverables->saveField(['frozen' => 1], $deliverableId);

        if($locking) {
            $this->task->feedMe('Deployment into environment ' . $envName . ' locked instance.');
        }else {
            $this->task->feedMe('Deployment into environment ' . $envName . ' unlocked instance.');
        }
        return true;
    }
}
