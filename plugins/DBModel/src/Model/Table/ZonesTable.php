<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Zone;
use DBModel\Model\Table\AppTable;

/**
 * Zones Model
 *
 * @property \Cake\ORM\Association\HasMany $Bridges
 * @property \Cake\ORM\Association\HasMany $EngineHosts
 * @property \Cake\ORM\Association\HasMany $ZoneProperties
 */
class ZonesTable extends AppTable
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

        $this->table('zones');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Bridges', [
            'foreignKey' => 'zone_id'
        ]);
        $this->hasOne('EngineHosts', [
            'foreignKey' => 'zone_id'
        ]);
        $this->hasMany('ZoneProperties', [
            'dependent' => true,
            'foreignKey' => 'zone_id'
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Zone already exists with that name'])
            ->notEmpty('name');

        return $validator;
    }
}
