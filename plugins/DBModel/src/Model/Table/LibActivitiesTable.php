<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\LibActivity;

/**
 * LibActivities Model
 *
 * @property \Cake\ORM\Association\HasMany $Activities
 * @property \Cake\ORM\Association\HasMany $DefActivities
 * @property \Cake\ORM\Association\HasMany $LibTasks
 */
class LibActivitiesTable extends Table
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

        $this->table('lib_activities');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Activities', [
            'foreignKey' => 'lib_activity_id',
            'className' => 'DBModel.Activities'
        ]);
        $this->hasMany('DefActivities', [
            'foreignKey' => 'lib_activity_id',
            'className' => 'DBModel.DefActivities'
        ]);
        $this->hasMany('LibTasks', [
            'foreignKey' => 'lib_activity_id',
            'className' => 'DBModel.LibTasks'
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
            ->allowEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('connectivity');

        $validator
            ->allowEmpty('needs_channel');

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
        $rules->add($rules->isUnique(['name']));
        return $rules;
    }
}
