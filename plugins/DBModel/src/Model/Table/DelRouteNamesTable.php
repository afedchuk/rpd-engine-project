<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DelRouteNames Model
 *
 * @property \Cake\ORM\Association\HasMany $DelRoutes
 * @property \Cake\ORM\Association\HasMany $Deliverables
 *
 * @method \DBModel\Model\Entity\DelRouteName get($primaryKey, $options = [])
 * @method \DBModel\Model\Entity\DelRouteName newEntity($data = null, array $options = [])
 * @method \DBModel\Model\Entity\DelRouteName[] newEntities(array $data, array $options = [])
 * @method \DBModel\Model\Entity\DelRouteName|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DBModel\Model\Entity\DelRouteName patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \DBModel\Model\Entity\DelRouteName[] patchEntities($entities, array $data, array $options = [])
 * @method \DBModel\Model\Entity\DelRouteName findOrCreate($search, callable $callback = null)
 */
class DelRouteNamesTable extends Table
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

        $this->table('del_route_names');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('DelRoutes', [
            'foreignKey' => 'del_route_name_id',
            'className' => 'DBModel.DelRoutes'
        ]);
        $this->hasMany('Deliverables', [
            'foreignKey' => 'del_route_name_id',
            'className' => 'DBModel.Deliverables'
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
            ->allowEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('type');

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
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }
}
