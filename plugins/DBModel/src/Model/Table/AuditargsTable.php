<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Table\AppTable;
use DBModel\Model\Entity\Auditarg;

/**
 * Auditargs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Audits
 */
class AuditargsTable extends AppTable
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

        $this->table('auditargs');
        $this->displayField('name');
        $this->primaryKey(['id']);

        $this->belongsTo('Oddits', [
            'foreignKey' => 'audit_id',
            'className' => 'DBModel.Oddits',
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
            ->allowEmpty('value');

        $validator
            ->allowEmpty('name');

        $validator
            ->notEmpty('audit_id');

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
        $rules->add($rules->existsIn(['audit_id'], 'Oddits'));
        return $rules;
    }
}
