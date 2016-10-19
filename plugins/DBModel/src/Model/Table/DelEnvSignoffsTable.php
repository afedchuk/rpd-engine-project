<?php
namespace DBModel\Model\Table;

use DBModel\Model\Entity\DelEnvSignoff;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Table\AppTable;

/**
 * DelEnvSignoffs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $DelEnvs
 */
class DelEnvSignoffsTable extends AppTable
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

        $this->table('del_env_signoffs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('DelEnvs', [
            'foreignKey' => 'del_env_id'
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
            ->allowEmpty('contact');

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
        $rules->add($rules->existsIn(['del_env_id'], 'DelEnvs'));
        return $rules;
    }
}
