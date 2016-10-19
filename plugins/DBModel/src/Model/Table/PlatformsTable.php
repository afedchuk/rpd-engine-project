<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Platform;

/**
 * Platforms Model
 *
 * @property \Cake\ORM\Association\BelongsTo $References
 * @property \Cake\ORM\Association\HasMany $Modules
 * @property \Cake\ORM\Association\HasMany $PlatformProperties
 * @property \Cake\ORM\Association\HasMany $Platstrings
 * @property \Cake\ORM\Association\HasMany $Renores
 * @property \Cake\ORM\Association\HasMany $Scripts
 */
class PlatformsTable extends AppTable
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

        $this->table('platforms');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('References', [
            'foreignKey' => 'reference_id',
            'className' => 'DBModel.References'
        ]);
        $this->hasMany('Modules', [
            'foreignKey' => 'platform_id',
            'className' => 'DBModel.Modules'
        ]);
        $this->hasMany('PlatformProperties', [
            'foreignKey' => 'platform_id',
            'className' => 'DBModel.PlatformProperties'
        ]);
        $this->hasMany('Platstrings', [
            'foreignKey' => 'platform_id',
            'className' => 'DBModel.Platstrings'
        ]);
        $this->hasMany('Renores', [
            'foreignKey' => 'platform_id',
            'className' => 'DBModel.Renores'
        ]);
        $this->hasMany('Scripts', [
            'foreignKey' => 'platform_id',
            'className' => 'DBModel.Scripts'
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
            ->allowEmpty('name');

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
        $rules->add($rules->existsIn(['reference_id'], 'References'));
        return $rules;
    }
}
