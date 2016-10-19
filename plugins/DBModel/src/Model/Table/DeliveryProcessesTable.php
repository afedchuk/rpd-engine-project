<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\DeliveryProcess;
use DBModel\Model\Table\AppTable;

/**
 * DeliveryProcesses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ProvisionProcesses
 * @property \Cake\ORM\Association\BelongsTo $Processes
 * @property \Cake\ORM\Association\BelongsTo $Channels
 * @property \Cake\ORM\Association\BelongsTo $Handlers
 * @property \Cake\ORM\Association\BelongsTo $Solids
 * @property \Cake\ORM\Association\BelongsTo $Deliveries
 */
class DeliveryProcessesTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('delivery_processes');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('ProvisionProcesses', [
            'foreignKey' => 'provision_process_id',
            'className' => 'DBModel.ProvisionProcesses'
        ]);
        $this->belongsTo('Processes', [
            'foreignKey' => 'process_id',
            'className' => 'DBModel.Processes'
        ]);
        $this->belongsTo('Channels', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.Channels'
        ]);
        $this->belongsTo('Handlers', [
            'foreignKey' => 'handler_id',
            'className' => 'DBModel.Handlers'
        ]);
        $this->belongsTo('Solids', [
            'foreignKey' => 'solid_id',
            'className' => 'DBModel.Solids'
        ]);
        $this->belongsTo('Deliveries', [
            'foreignKey' => 'delivery_id',
            'className' => 'DBModel.Deliveries'
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
            ->allowEmpty('paths');

        $validator
            ->allowEmpty('status');

        $validator
            ->allowEmpty('pattern');

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

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
     * Consistency check for tasks
     *
     * @return bool
     */
    public function consistencyCheck(array &$ids = [])
    {
        $processes = $this->Processes->find('all')
                        ->where(['flag' => 'QUEUED'])
                        ->contain(['DeliveryProcesses'])
                        ->toArray();
        if(!empty($processes)) {
            foreach ($processes as $key => $value) {
                if(!isset($value->delivery_processes[0]->id)) {
                    continue;
                }
                $delivery = $this->Deliveries->find()->where(['id' => $value->delivery_processes[0]->id])->first();
                if(in_array($delivery->status, ['cancelled', 'fail'])) {
                    $process = $this->Processes->get($value->id); 
                    $this->Processes->patchEntity($process, ['flag' => 'CANCELLED']);
                    if(!$this->Processes->save($process)) {
                        return $process->Processes->errors();
                    }
                }
            }
        }
        return true;
    }
}
