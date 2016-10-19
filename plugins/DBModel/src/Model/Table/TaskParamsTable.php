<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\TaskParam;
use DBModel\Model\Table\AppTable;

/**
 * TaskParams Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Tasks
 * @property \Cake\ORM\Association\BelongsTo $Activities
 * @property \Cake\ORM\Association\HasMany $TaskParamDefaults
 * @property \Cake\ORM\Association\HasMany $TaskParamOpts
 */
class TaskParamsTable extends AppTable
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

        $this->table('task_params');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id',
            'className' => 'DBModel.Tasks'
        ]);
        $this->belongsTo('Activities', [
            'foreignKey' => 'activity_id',
            'className' => 'DBModel.Activities'
        ]);
        $this->hasMany('TaskParamDefaults', [
            'foreignKey' => 'task_param_id',
            'className' => 'DBModel.TaskParamDefaults'
        ]);
        $this->hasMany('TaskParamOpts', [
            'foreignKey' => 'task_param_id',
            'className' => 'DBModel.TaskParamOpts'
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
            ->integer('sequence')
            ->allowEmpty('sequence');

        $validator
            ->allowEmpty('occurance');

        $validator
            ->allowEmpty('type');

        $validator
            ->allowEmpty('correlation');

        $validator
            ->allowEmpty('name');

        $validator
            ->allowEmpty('optional');

        $validator
            ->allowEmpty('description');

        $validator
            ->allowEmpty('separator');

        $validator
            ->allowEmpty('modifiable');

        $validator
            ->allowEmpty('explode');

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
        $rules->add($rules->existsIn(['task_id'], 'Tasks'));
        $rules->add($rules->existsIn(['activity_id'], 'Activities'));
        return $rules;
    }
}
