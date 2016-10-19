<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\SchedUriAssetProp;
use DBModel\Model\Table\AppTable;

/**
 * SchedUriAssetProps Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Scheds
 * @property \Cake\ORM\Association\BelongsTo $Properties
 */
class SchedUriAssetPropsTable extends AppTable
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

        $this->table('sched_uri_asset_props');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Scheds', [
            'foreignKey' => 'sched_id',
            'joinType' => 'INNER',
            'className' => 'DBModel.Scheds'
        ]);
        $this->belongsTo('Properties', [
            'foreignKey' => 'property_id',
            'joinType' => 'INNER',
            'className' => 'DBModel.Properties'
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
            ->integer('property_type')
            ->requirePresence('property_type', 'create')
            ->notEmpty('property_type');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('value', 'create')
            ->notEmpty('value');

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
        $rules->add($rules->existsIn(['property_id'], 'Properties'));
        return $rules;
    }
}
