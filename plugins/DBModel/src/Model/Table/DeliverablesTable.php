<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Event\Event, ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Deliverable;
use DBModel\Model\Table\AppTable;
use Cake\ORM\TableRegistry;

/**
 * Deliverables Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Assets
 * @property \Cake\ORM\Association\BelongsTo $DelRouteNames
 * @property \Cake\ORM\Association\BelongsTo $Artifacts
 * @property \Cake\ORM\Association\BelongsTo $Deliveries
 * @property \Cake\ORM\Association\BelongsTo $Deliverables
 * @property \Cake\ORM\Association\HasMany $Artifacts
 * @property \Cake\ORM\Association\HasMany $DeliverableRoles
 * @property \Cake\ORM\Association\HasMany $Deliverables
 * @property \Cake\ORM\Association\HasMany $Deliveries
 * @property \Cake\ORM\Association\HasMany $Solids
 */
class DeliverablesTable extends AppTable
{
    const EMPTY = 'Empty';
    const CONSTRUCT = 'Construct';
    const ERROR = 'Error';
    const READY = 'Ready';
    const EXPIRED = 'Expired';
    const WAIT = 'Wait';
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('deliverables');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->Loches = TableRegistry::get('DBModel.Loches'); 

        $this->belongsTo('DBModel.Assets', [
            'foreignKey' => 'asset_id',
            
        ]);
        $this->belongsTo('DBModel.DelRouteNames', [
            'foreignKey' => 'del_route_name_id'
        ]);
        $this->hasOne('DBModel.Artifacts', [
            'foreignKey' => 'deliverable_id'
        ]);
        $this->hasMany('DBModel.DeliverableRoles', [
            'foreignKey' => 'deliverable_id'
        ]);
   
        $this->hasMany('DBModel.Deliveries', [
            'foreignKey' => 'deliverable_id'
        ]);
        $this->hasMany('DBModel.Solids', [
            'foreignKey' => 'deliverable_id'
        ]);

        $this->addBehavior('DBModel.QTimestamp', [
            'field' => 'gmt_created',
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
            ->allowEmpty('name');

        $validator
            ->allowEmpty('artifact_name');

        $validator
            ->allowEmpty('type');

        $validator
            ->allowEmpty('status');

        $validator
            ->integer('gmt_created')
            ->allowEmpty('gmt_created');

        $validator
            ->integer('locked')
            ->allowEmpty('locked');

        $validator
            ->integer('frozen')
            ->allowEmpty('frozen');

        $validator
            ->integer('cloaked')
            ->allowEmpty('cloaked');

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
        $rules->add($rules->existsIn(['asset_id'], 'Assets'));
        $rules->add($rules->existsIn(['del_route_name_id'], 'DelRouteNames'));
        $rules->add($rules->existsIn(['artifact_id'], 'Artifacts'));
        $rules->add($rules->existsIn(['delivery_id'], 'Deliveries'));
        // $rules->add($rules->existsIn(['deliverable_id'], 'Deliverables'));
        return $rules;
    }

    /**
     * Get Deliverable id by engibe ID and counter
     * @param string $engineId  Engine ID
     * @param string $counter  Engine ID
     * @return integer 
    **/

    public function getDeliverableId(int $engineId, int &$counter)
    {     
        $recordCount = $this->find('all',
                          ['conditions' => ['Deliverables.status IN' => ['Empty', 'Construct']] , 'order' =>  ['Deliverables.status' => 'ASC'] ] )
                       ->count();
        if($counter > $recordCount ) {
            $counter = 0;
        }

        if($recordCount === 0){
            return([
                      ['deliverables'=>[
                                        'records'=>'No records found'
                                      ]]
                      ]
                    );
        }

        // Found something!
        // Get a Loch on the deliverable
        $lockUid = uniqid($engineId,true);
        if(!$this->Loches->getLock('deliverables', $lockUid, 3, 1, 0)) {
            // Already Locked, let someone try getting it.
            QLog::debug('Already locked. Could not get the lock');
            return(0);
        }

        // Loch Got, update the record if any are found...
        $record = $this->find('all',
                          ['conditions' => ['Deliverables.status IN' => ['Empty', 'Construct']] , 'order' =>  ['Deliverables.status' => 'ASC'] ] )
                       ->toArray();
        if(empty($record)) {
            // No more record, free loch and return.
            QLog::debug('No more records. No pending engines exist');
            $this->Loches->put('deliverables', $lockUid);
            return(0);
        }

        // See if we can update the record.
        if(isset($record[$counter]['id'])) {
            $result = $this->query()
                ->update()
                ->set(['status' => $engineId ])
                ->where(['id' => $record[$counter]['id']])
                ->execute();
            if(!$result) {
                QLog::error('Error updating engine record for populating deliverable.');
                $this->Loches->put('deliverables', $lockUid);
                return(0);
            }
            $this->Loches->put('deliverables', $lockUid);
            return $record[$counter]['id'];
        }
        $this->Loches->put('deliverables', $lockUid);
        return(0);
    }

}
