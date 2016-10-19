<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Task;
use DBModel\Model\Table\AppTable;

/**
 * Tasks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Activities
 * @property \Cake\ORM\Association\BelongsTo $LibTasks
 * @property \Cake\ORM\Association\BelongsTo $Engines
 * @property \Cake\ORM\Association\BelongsTo $ChannelRevs
 * @property \Cake\ORM\Association\BelongsTo $Bridges
 * @property \Cake\ORM\Association\HasMany $TaskDepends
 * @property \Cake\ORM\Association\HasMany $TaskFeeds
 * @property \Cake\ORM\Association\HasMany $TaskParams
 */

class TasksTable extends AppTable
{
    const DONE = 'DONE';
    const COMPLETE = 'COMPLETE';
    const WAIT = 'WAIT';
    const STOPPED = 'STOPPED';
    const SUSPENDED = 'SUSPENDED';
    const ACTIVE = 'ACTIVE';
    const ENGINEWAIT = 'ENGINEWAIT';
    const REENTER = 'REENTER';
    
    protected $consistency =  ['conditions' => [['engine_id !=' => 0, 'flag' => 'ACTIVE']], 'data' => ['engine_id' => 0, 'flag' => 'STOPPED']];
    public static $status = [SELF::DONE, SELF::COMPLETE, SELF::WAIT, SELF::STOPPED, SELF::SUSPENDED, SELF::ACTIVE, SELF::ENGINEWAIT, SELF::REENTER];
    public static $busyStatus = [SELF::DONE, SELF::COMPLETE, SELF::WAIT, SELF::STOPPED, SELF::SUSPENDED];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('tasks');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Activities', [
            'foreignKey' => 'activity_id',
            'className' => 'DBModel.Activities'
        ]);
        $this->belongsTo('LibTasks', [
            'foreignKey' => 'lib_task_id',
            'className' => 'DBModel.LibTasks'
        ]);
        $this->belongsTo('Engines', [
            'foreignKey' => 'engine_id',
            'className' => 'DBModel.Engines'
        ]);
        $this->belongsTo('ChannelRevs', [
            'foreignKey' => 'channel_rev_id',
            'className' => 'DBModel.ChannelRevs'
        ]);
        $this->belongsTo('Bridges', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.Bridges'
        ]);
        $this->hasMany('TaskDepends', [
            'foreignKey' => 'task_id',
            'className' => 'DBModel.TaskDepends'
        ]);
        $this->hasMany('TaskFeeds', [
            'foreignKey' => 'task_id',
            'className' => 'DBModel.TaskFeeds'
        ]);
        $this->hasMany('TaskParams', [
            'foreignKey' => 'task_id',
            'className' => 'DBModel.TaskParams'
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
            ->allowEmpty('explode_type');

        $validator
            ->allowEmpty('module');

        $validator
            ->allowEmpty('flag');

        $validator
            ->integer('gmt_start')
            ->allowEmpty('gmt_start');

        $validator
            ->integer('duration')
            ->allowEmpty('duration');

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
     * Clean up all tasks related with engine id
     *
     * @param int $id engine id.
     * @return bool
     */
    public function engineClean(array $items)
    { 
        foreach ($items as $key => $value) {
            if(in_array($value->flag, array('ACTIVE', 'REENTER'))) {
                $task = $this->get($value->id); 
                $this->patchEntity($task, ['flag' => 'STOPPED']);
                if(!$this->save($task)) {
                    return $task->errors();
                } else {
                    if(($result = $this->TaskFeeds->putLine($value->id, __("Engine process shutdown for unknown reason."))) !== true) {
                        return $result;
                    }
                }
            }
        }
        return true;
    }

    /**
     * Consistency hook
     *
     * @param array $item table data
     * @return void
     */
    public function consistencyHook(\DBModel\Model\Entity\Task $item)
    {
        $this->TaskFeeds->putLine($item->id, __("Engine process shutdown for unknown reason."));
    }
}
