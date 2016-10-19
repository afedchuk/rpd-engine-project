<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\UriProperty;
use DBModel\Model\Table\AppTable;

/**
 * UriProperties Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Uris
 *
 * @method \DBModel\Model\Entity\UriProperty get($primaryKey, $options = [])
 * @method \DBModel\Model\Entity\UriProperty newEntity($data = null, array $options = [])
 * @method \DBModel\Model\Entity\UriProperty[] newEntities(array $data, array $options = [])
 * @method \DBModel\Model\Entity\UriProperty|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DBModel\Model\Entity\UriProperty patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \DBModel\Model\Entity\UriProperty[] patchEntities($entities, array $data, array $options = [])
 * @method \DBModel\Model\Entity\UriProperty findOrCreate($search, callable $callback = null)
 */
class UriPropertiesTable extends AppTable
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

        $this->table('uri_properties');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Uris', [
            'foreignKey' => 'uri_id',
            'className' => 'DBModel.Uris'
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
            ->requirePresence('name')
            ->notEmpty('name');

        $validator
            ->requirePresence('value')
            ->notEmpty('value');

        $validator
            ->integer('locked')
            ->allowEmpty('locked');

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

        return $rules;
    }
}
