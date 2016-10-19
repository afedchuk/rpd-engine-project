<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\DefActivity;

/**
 * DefActivities Model
 *
 * @property \Cake\ORM\Association\BelongsTo $DefProcesses
 * @property \Cake\ORM\Association\BelongsTo $LibActivities
 * @property \Cake\ORM\Association\HasMany $Activities
 * @property \Cake\ORM\Association\HasMany $DefActivityDepends
 * @property \Cake\ORM\Association\HasMany $DefTaskParamDefaults
 * @property \Cake\ORM\Association\HasMany $DefTaskParams
 */
class DefActivitiesTable extends Table
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

        $this->table('def_activities');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('DefProcesses', [
            'foreignKey' => 'def_process_id',
            'className' => 'DBModel.DefProcesses'
        ]);
        $this->belongsTo('LibActivities', [
            'foreignKey' => 'lib_activity_id',
            'className' => 'DBModel.LibActivities'
        ]);
        $this->hasMany('Activities', [
            'foreignKey' => 'def_activity_id',
            'className' => 'DBModel.Activities'
        ]);
        $this->hasMany('DefActivityDepends', [
            'foreignKey' => 'def_activity_id',
            'className' => 'DBModel.DefActivityDepends'
        ]);
        $this->hasMany('DefTaskParamDefaults', [
            'foreignKey' => 'def_activity_id',
            'className' => 'DBModel.DefTaskParamDefaults'
        ]);
        $this->hasMany('DefTaskParams', [
            'foreignKey' => 'def_activity_id',
            'className' => 'DBModel.DefTaskParams'
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
            ->allowEmpty('active');

        $validator
            ->integer('activity_timeout')
            ->allowEmpty('activity_timeout');

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
        $rules->add($rules->existsIn(['def_process_id'], 'DefProcesses'));
        $rules->add($rules->existsIn(['lib_activity_id'], 'LibActivities'));
        return $rules;
    }
}
