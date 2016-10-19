<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Event\Event, ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Asset;
use DBModel\Model\Table\AppTable;
use Cake\ORM\TableRegistry;

/**
 * Assets Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Products
 * @property \Cake\ORM\Association\HasMany $AssetProperties
 * @property \Cake\ORM\Association\HasMany $AssetRoles
 * @property \Cake\ORM\Association\HasMany $Deliverables
 * @property \Cake\ORM\Association\HasMany $DeliveryPreviews
 * @property \Cake\ORM\Association\HasMany $SpinPreviews
 * @property \Cake\ORM\Association\HasMany $Uris
 */
class AssetsTable extends AppTable
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

        $this->table('assets');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->SchedProperties = TableRegistry::get('DBModel.SchedProperties'); 
        $this->SchedSelectedOptions = TableRegistry::get('DBModel.SchedSelectedOptions'); 
        $this->SchedUriAssetProps = TableRegistry::get('DBModel.SchedUriAssetProps'); 

        $this->belongsTo('DBModel.Products', [
            'foreignKey' => 'product_id'
        ]);
        $this->hasMany('DBModel.AssetProperties', [
            'foreignKey' => 'asset_id'
        ]);
        $this->hasMany('DBModel.AssetRoles', [
            'foreignKey' => 'asset_id'
        ]);
        $this->hasMany('DBModel.Deliverables', [
            'foreignKey' => 'asset_id'
        ]);
        $this->hasMany('DBModel.DeliveryPreviews', [
            'foreignKey' => 'asset_id'
        ]);
        $this->hasMany('DBModel.SpinPreviews', [
            'foreignKey' => 'asset_id'
        ]);
        $this->hasMany('DBModel.Uris', [
            'foreignKey' => 'asset_id'
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
            ->integer('gmt_created')
            ->allowEmpty('gmt_created');

        $validator
            ->allowEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('type');

        $validator
            ->allowEmpty('revision');

        $validator
            ->integer('nextrev')
            ->allowEmpty('nextrev');

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
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        return $rules;
    }

    

    /**
     * Event is fired before an entity is deleted
     *
     * @param Cake\Event\Event $event The rules object to be modified.
     * @param Cake\Datasource\EntityInterface $entity The rules object to be modified.
     * @param ArrayObject $options The rules object to be modified.
     * @return bool
     */

    public function afterDelete(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->deleteSchedsData($entity);
        return true;

    }

}
