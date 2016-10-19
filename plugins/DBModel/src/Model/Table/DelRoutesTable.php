<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DelRoutes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $DelRouteNames
 * @property \Cake\ORM\Association\BelongsTo $DelEnvs
 * @property \Cake\ORM\Association\BelongsTo $Groops
 *
 * @method \DBModel\Model\Entity\DelRoute get($primaryKey, $options = [])
 * @method \DBModel\Model\Entity\DelRoute newEntity($data = null, array $options = [])
 * @method \DBModel\Model\Entity\DelRoute[] newEntities(array $data, array $options = [])
 * @method \DBModel\Model\Entity\DelRoute|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DBModel\Model\Entity\DelRoute patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \DBModel\Model\Entity\DelRoute[] patchEntities($entities, array $data, array $options = [])
 * @method \DBModel\Model\Entity\DelRoute findOrCreate($search, callable $callback = null)
 */
class DelRoutesTable extends Table
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

        $this->table('del_routes');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('DelRouteNames', [
            'foreignKey' => 'del_route_name_id',
            'className' => 'DBModel.DelRouteNames'
        ]);
        $this->belongsTo('DelEnvs', [
            'foreignKey' => 'del_env_id',
            'className' => 'DBModel.DelEnvs'
        ]);
        $this->belongsTo('Groops', [
            'foreignKey' => 'groop_id',
            'className' => 'DBModel.Groops'
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
            ->integer('sequence')
            ->allowEmpty('sequence');

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
        $rules->add($rules->existsIn(['del_route_name_id'], 'DelRouteNames'));
        $rules->add($rules->existsIn(['del_env_id'], 'DelEnvs'));
        $rules->add($rules->existsIn(['groop_id'], 'Groops'));

        return $rules;
    }
}
