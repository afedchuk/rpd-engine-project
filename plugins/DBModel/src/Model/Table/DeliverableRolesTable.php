<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DeliverableRoles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Deliverables
 * @property \Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \DBModel\Model\Entity\DeliverableRole get($primaryKey, $options = [])
 * @method \DBModel\Model\Entity\DeliverableRole newEntity($data = null, array $options = [])
 * @method \DBModel\Model\Entity\DeliverableRole[] newEntities(array $data, array $options = [])
 * @method \DBModel\Model\Entity\DeliverableRole|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DBModel\Model\Entity\DeliverableRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \DBModel\Model\Entity\DeliverableRole[] patchEntities($entities, array $data, array $options = [])
 * @method \DBModel\Model\Entity\DeliverableRole findOrCreate($search, callable $callback = null)
 */
class DeliverableRolesTable extends Table
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

        $this->table('deliverable_roles');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Deliverables', [
            'foreignKey' => 'deliverable_id',
            'className' => 'DBModel.Deliverables'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'className' => 'DBModel.Roles'
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
        $rules->add($rules->existsIn(['deliverable_id'], 'Deliverables'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
