<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\ZoneProperty;
use DBModel\Model\Table\AppTable;
use Cake\Event\Event, ArrayObject;
use Cake\Datasource\EntityInterface;

/**
 * ZoneProperties Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Zones
 */
class ZonePropertiesTable extends AppTable
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

        $this->table('zone_properties');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Zones', [
            'foreignKey' => 'zone_id',
            'joinType' => 'INNER',
            'className' => 'DBModel.Zones'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('value');

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
        $rules->add($rules->existsIn(['zone_id'], 'Zones'));
        return $rules;
    }

    /**
     * Event is fired before each entity is saved.
     *
     * @param Cake\Event\Event $event Event instance.
     * @param DBModel\Model\Entity\ZoneProperty $entity instance of entity.
     * @param ArrayObjecty $options array object options.
     * @return bool
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $entity->value = $entity->encryptValue();
        return true;
    }
}
