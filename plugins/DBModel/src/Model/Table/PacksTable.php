<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Pack;
use DBModel\Model\Table\AppTable;

/**
 * Packs Model
 *
 * @property \Cake\ORM\Association\HasMany $ChannelTypes
 * @property \Cake\ORM\Association\HasMany $Cmaps
 * @property \Cake\ORM\Association\HasMany $Lognotes
 * @property \Cake\ORM\Association\HasMany $Renores
 * @property \Cake\ORM\Association\HasMany $Scripts
 */
class PacksTable extends AppTable
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

        $this->table('packs');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('ChannelTypes', [
            'foreignKey' => 'pack_id',
            'className' => 'DBModel.ChannelTypes'
        ]);
        $this->hasMany('Cmaps', [
            'foreignKey' => 'pack_id',
            'className' => 'DBModel.Cmaps'
        ]);
        $this->hasMany('Lognotes', [
            'foreignKey' => 'pack_id',
            'className' => 'DBModel.Lognotes'
        ]);
        $this->hasMany('Renores', [
            'foreignKey' => 'pack_id',
            'className' => 'DBModel.Renores'
        ]);
        $this->hasMany('Scripts', [
            'foreignKey' => 'pack_id',
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
}
