<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Module;
use DBModel\Model\Table\AppTable;

/**
 * Modules Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Platforms
 * @property \Cake\ORM\Association\BelongsTo $Bits
 * @property \Cake\ORM\Association\HasMany $Analyzers
 * @property \Cake\ORM\Association\HasMany $Events
 * @property \Cake\ORM\Association\HasMany $Lbs
 * @property \Cake\ORM\Association\HasMany $Vms
 */
class ModulesTable extends AppTable
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

        $this->table('modules');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('DBModel.QTimestamp', [
            'field' => 'gmt_created',
            ]);
        
        $this->belongsTo('Platforms', [
            'foreignKey' => 'platform_id',
            'className' => 'DBModel.Platforms'
        ]);
        $this->belongsTo('Bits', [
            'foreignKey' => 'bits_id',
            'className' => 'DBModel.Bits'
        ]);

        $this->hasMany('Events', [
            'foreignKey' => 'module_id',
            'className' => 'DBModel.Events'
        ]);
        $this->hasMany('Lbs', [
            'foreignKey' => 'module_id',
            'className' => 'DBModel.Lbs'
        ]);
        $this->hasMany('Vms', [
            'foreignKey' => 'module_id',
            'className' => 'DBModel.Vms'
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
            ->notEmpty('name');

        $validator
            ->integer('version')
            ->allowEmpty('version');

        $validator
            ->integer('gmt_created')
            ->allowEmpty('gmt_created');

        $validator
            ->integer('siz')
            ->allowEmpty('siz');

        $validator
            ->allowEmpty('md5');

        $validator
            ->allowEmpty('description');

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
        $rules->add($rules->existsIn(['platform_id'], 'Platforms'));
        return $rules;
    }
}
