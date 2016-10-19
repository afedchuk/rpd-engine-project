<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\UriDepend;
use DBModel\Model\Table\AppTable;

/**
 * UriDepends Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Uris
 * @property \Cake\ORM\Association\BelongsTo $UriDepends
 * @property \Cake\ORM\Association\HasMany $UriDepends
 *
 * @method \DBModel\Model\Entity\UriDepend get($primaryKey, $options = [])
 * @method \DBModel\Model\Entity\UriDepend newEntity($data = null, array $options = [])
 * @method \DBModel\Model\Entity\UriDepend[] newEntities(array $data, array $options = [])
 * @method \DBModel\Model\Entity\UriDepend|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DBModel\Model\Entity\UriDepend patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \DBModel\Model\Entity\UriDepend[] patchEntities($entities, array $data, array $options = [])
 * @method \DBModel\Model\Entity\UriDepend findOrCreate($search, callable $callback = null)
 */
class UriDependsTable extends AppTable
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

        $this->table('uri_depends');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Uris', [
            'foreignKey' => 'uri_id',
            'className' => 'DBModel.Uris'
        ]);
        $this->belongsTo('UriDepends', [
            'foreignKey' => 'uri_depend_id',
            'className' => 'DBModel.UriDepends'
        ]);
        $this->hasMany('UriDepends', [
            'foreignKey' => 'uri_depend_id',
            'className' => 'DBModel.UriDepends'
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
            ->requirePresence('type')
            ->notEmpty('type');

        $validator
            ->requirePresence('uri_id')
            ->notEmpty('uri_id');
            
        $validator
            ->requirePresence('uri_depend_id')
            ->notEmpty('uri_depend_id');

        $validator
            ->integer('scope')
            ->allowEmpty('scope');

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
        $rules->add($rules->existsIn(['uri_id'], 'Uris'));
        $rules->add($rules->existsIn(['uri_depend_id'], 'UriDepends'));

        return $rules;
    }
}
