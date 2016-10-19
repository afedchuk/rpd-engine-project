<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Process;
use DBModel\Model\Table\AppTable;

/**
 * Processes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $DefProcesses
 * @property \Cake\ORM\Association\BelongsTo $Engines
 * @property \Cake\ORM\Association\HasMany $Activities
 * @property \Cake\ORM\Association\HasMany $ChannelConfs
 * @property \Cake\ORM\Association\HasMany $ChannelProcesses
 * @property \Cake\ORM\Association\HasMany $ChannelTypes
 * @property \Cake\ORM\Association\HasMany $DeliveryProcesses
 * @property \Cake\ORM\Association\HasMany $Messages
 * @property \Cake\ORM\Association\HasMany $ProcessDepends
 */
class ProcessesTable extends AppTable
{
    const INCOMPLETE = 'INCOMPLETE';
    const STOPPED = 'STOPPED';
    const DONE = 'DONE';
    const COMPLETE = 'COMPLETE';
    const ACTIVE = 'ACTIVE';
    const QUEUED = 'QUEUED';

    protected $consistency =  ['conditions' => [['engine_id !=' => 0 ]], 'data' => ['engine_id' => 0, 'flag' => 'STOPPED']];
    public static $status = [SELF::INCOMPLETE, SELF::STOPPED, SELF::DONE, SELF::COMPLETE, SELF::ACTIVE, SELF::QUEUED];
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('processes');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('DefProcesses', [
            'foreignKey' => 'def_process_id',
            'className' => 'DBModel.DefProcesses'
        ]);
        $this->belongsTo('Engines', [
            'foreignKey' => 'engine_id',
            'className' => 'DBModel.Engines'
        ]);
        $this->hasMany('Activities', [
            'foreignKey' => 'process_id',
            'className' => 'DBModel.Activities'
        ]);
        $this->hasMany('ChannelConfs', [
            'foreignKey' => 'process_id',
            'className' => 'DBModel.ChannelConfs'
        ]);
        $this->hasMany('ChannelProcesses', [
            'foreignKey' => 'process_id',
            'className' => 'DBModel.ChannelProcesses'
        ]);
        $this->hasMany('ChannelTypes', [
            'foreignKey' => 'process_id',
            'className' => 'DBModel.ChannelTypes'
        ]);
        $this->hasMany('DeliveryProcesses', [
            'foreignKey' => 'process_id',
            'className' => 'DBModel.DeliveryProcesses'
        ]);
        $this->hasMany('Messages', [
            'foreignKey' => 'process_id',
            'className' => 'DBModel.Messages'
        ]);
        $this->hasMany('ProcessDepends', [
            'foreignKey' => 'process_id',
            'className' => 'DBModel.ProcessDepends'
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
            ->allowEmpty('type');

        $validator
            ->allowEmpty('flag');

        $validator
            ->integer('gmt_flag')
            ->allowEmpty('gmt_flag');

        $validator
            ->integer('gmt_start')
            ->allowEmpty('gmt_start');

        $validator
            ->integer('duration')
            ->allowEmpty('duration');

        $validator
            ->allowEmpty('message');

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
     * Unsigned processes from engine
     *
     * @param array $items process data.
     * @return bool
     */
    public function engineClean(array $items)
    { 
        foreach ($items as $key => $value) {
            if(in_array($value->flag, array('ACTIVE'))) {
                $process = $this->get($value->id); 
                $this->patchEntity($process, ['flag' => 'STOPPED', 'engine_id' => 0]);
                if(!$this->save($process)) {
                    return $process->errors();
                }
            }
        }
        return true;
    }
}
