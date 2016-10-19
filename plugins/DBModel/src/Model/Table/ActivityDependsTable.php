<?php
namespace DBModel\Model\Table;

use DBModel\Model\Entity\ActivityDepend;
use DBModel\Model\Table\AppTable;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * ActivityDepends Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Activities
 * @property \Cake\ORM\Association\BelongsTo $DefDepends
 */
class ActivityDependsTable extends AppTable
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

        $this->table('activity_depends');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Activities', [
            'foreignKey' => 'activity_id'
        ]);
        $this->belongsTo('DefDepends', [
            'foreignKey' => 'def_depend_id'
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
            ->integer('scope')
            ->allowEmpty('scope');

        $validator
            ->integer('count')
            ->allowEmpty('count');

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
        $rules->add($rules->existsIn(['activity_id'], 'Activities'));
        $rules->add($rules->existsIn(['def_depend_id'], 'DefDepends'));
        return $rules;
    }
}
