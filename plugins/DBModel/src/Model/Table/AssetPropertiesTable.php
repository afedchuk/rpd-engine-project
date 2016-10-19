<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Event\Event, ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Validation\Validator;
use DBModel\Model\Entity\AssetProperty;
use DBModel\Model\Table\AppTable;
use Cake\ORM\TableRegistry;

/**
 * AssetProperties Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Assets
 * @property \Cake\ORM\Association\HasMany $Uris
 */
class AssetPropertiesTable extends AppTable
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

        $this->table('asset_properties');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('DBModel.Assets', [
            'foreignKey' => 'asset_id'
        ]);
        $this->hasMany('DBModel.Uris', [
            'foreignKey' => 'asset_property_id'
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
            ->allowEmpty('value');

        $validator
            ->integer('locked')
            ->allowEmpty('locked');

        $validator
            ->integer('asset_id')
            ->notEmpty('asset_id');

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
        return $rules;
    }

      /**
     * Event is fired before each entity is saved
     *
     * @param Cake\Event\Event $event The rules object to be modified.
     * @param Cake\Datasource\EntityInterface $entity The rules object to be modified.
     * @param ArrayObject $options The rules object to be modified.
     * @return bool
     */

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options) {
        $entity->value = $entity->encryptValue();
        return true;

    }
}
