<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Property;
use DBModel\Model\Table\AppTable;
use Cake\Event\Event, ArrayObject;
use Cake\Datasource\EntityInterface;

/**
 * Properties Model
 *
 * @property \Cake\ORM\Association\HasMany $SchedUriAssetProps
 */
class PropertiesTable extends AppTable
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

        $this->table('properties');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('SchedUriAssetProps', [
            'foreignKey' => 'property_id',
            'className' => 'DBModel.SchedUriAssetProps'
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
     * Event is fired before each entity is saved.
     *
     * @param Cake\Event\Event $event Event instance.
     * @param DBModel\Model\Entity\Property $entity instance of entity.
     * @param ArrayObjecty $options array object options.
     * @return bool
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $entity->value = $entity->encryptValue();
        return true;
    }
}
