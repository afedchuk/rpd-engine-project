<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\SchedSelectedOption;
use DBModel\Model\Table\AppTable;

/**
 * SchedSelectedOptions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Scheds
 * @property \Cake\ORM\Association\BelongsTo $Options
 */
class SchedSelectedOptionsTable extends AppTable
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

        $this->table('sched_selected_options');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Scheds', [
            'foreignKey' => 'sched_id',
            'joinType' => 'INNER',
            'className' => 'DBModel.Scheds'
        ]);
        $this->belongsTo('Options', [
            'foreignKey' => 'option_id',
            'joinType' => 'INNER',
            'className' => 'DBModel.Options'
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
            ->requirePresence('type', 'create')
            ->notEmpty('type');

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
        $rules->add($rules->existsIn(['sched_id'], 'Scheds'));
        $rules->add($rules->existsIn(['option_id'], 'Options'));
        return $rules;
    }
}
