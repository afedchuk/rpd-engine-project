<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\BuildCheckout;

/**
 * BuildCheckouts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Engines
 * @property \Cake\ORM\Association\BelongsTo $Solids
 * @property \Cake\ORM\Association\BelongsTo $Channels
 */
class BuildCheckoutsTable extends Table
{

    protected $consistency =  ['conditions' => [['status' => 'Q']], 'data' => ['status' => 'F']];
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('build_checkouts');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Engines', [
            'foreignKey' => 'engine_id',
            'className' => 'DBModel.Engines'
        ]);
        $this->belongsTo('Solids', [
            'foreignKey' => 'solid_id',
            'className' => 'DBModel.Solids'
        ]);
        $this->belongsTo('Channels', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.Channels'
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
            ->allowEmpty('build_path');

        $validator
            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['engine_id'], 'Engines'));
        $rules->add($rules->existsIn(['solid_id'], 'Solids'));
        $rules->add($rules->existsIn(['channel_id'], 'Channels'));
        return $rules;
    }
}
