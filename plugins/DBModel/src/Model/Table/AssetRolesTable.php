<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\AssetRole;
use DBModel\Model\Table\AppTable;

/**
 * AssetRoles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Assets
 * @property \Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \DBModel\Model\Entity\AssetRole get($primaryKey, $options = [])
 * @method \DBModel\Model\Entity\AssetRole newEntity($data = null, array $options = [])
 * @method \DBModel\Model\Entity\AssetRole[] newEntities(array $data, array $options = [])
 * @method \DBModel\Model\Entity\AssetRole|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DBModel\Model\Entity\AssetRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \DBModel\Model\Entity\AssetRole[] patchEntities($entities, array $data, array $options = [])
 * @method \DBModel\Model\Entity\AssetRole findOrCreate($search, callable $callback = null)
 */
class AssetRolesTable extends AppTable
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

        $this->table('asset_roles');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Assets', [
            'foreignKey' => 'asset_id',
            'className' => 'DBModel.Assets'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'className' => 'DBModel.AccessGroups'
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
            ->integer('asset_id')
            ->requirePresence('asset_id')
            ->notEmpty('asset_id');
        $validator
            ->integer('role_id')
            ->requirePresence('role_id')
            ->notEmpty('role_id');

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
        $rules->add($rules->existsIn(['asset_id'], 'Assets'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
