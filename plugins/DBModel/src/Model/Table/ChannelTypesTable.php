<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\ChannelType;
use DBModel\Model\Table\AppTable;

/**
 * ChannelTypes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Processes
 * @property \Cake\ORM\Association\BelongsTo $FailureDefProcesses
 * @property \Cake\ORM\Association\BelongsTo $ProvisionDefProcesses
 * @property \Cake\ORM\Association\BelongsTo $PostDefProcesses
 * @property \Cake\ORM\Association\BelongsTo $RemovalDefProcesses
 * @property \Cake\ORM\Association\BelongsTo $RefChannels
 * @property \Cake\ORM\Association\BelongsTo $Packs
 * @property \Cake\ORM\Association\HasMany $Bridges
 * @property \Cake\ORM\Association\HasMany $ChannelTypeProperties
 * @property \Cake\ORM\Association\HasMany $ChannelTypeRoles
 * @property \Cake\ORM\Association\HasMany $Channels
 * @property \Cake\ORM\Association\HasMany $HandlerPatterns
 */
class ChannelTypesTable extends AppTable
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

        $this->table('channel_types');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Processes', [
            'foreignKey' => 'process_id',
            'className' => 'DBModel.Processes'
        ]);
        $this->belongsTo('FailureDefProcesses', [
            'foreignKey' => 'failure_def_process_id',
            'className' => 'DBModel.FailureDefProcesses'
        ]);
        $this->belongsTo('ProvisionDefProcesses', [
            'foreignKey' => 'provision_def_process_id',
            'className' => 'DBModel.ProvisionDefProcesses'
        ]);
        $this->belongsTo('PostDefProcesses', [
            'foreignKey' => 'post_def_process_id',
            'className' => 'DBModel.PostDefProcesses'
        ]);
        $this->belongsTo('RemovalDefProcesses', [
            'foreignKey' => 'removal_def_process_id',
            'className' => 'DBModel.RemovalDefProcesses'
        ]);
        $this->belongsTo('RefChannels', [
            'foreignKey' => 'ref_channel_id',
            'className' => 'DBModel.RefChannels'
        ]);
        $this->belongsTo('Packs', [
            'foreignKey' => 'pack_id',
            'className' => 'DBModel.Packs'
        ]);
        $this->hasMany('Bridges', [
            'foreignKey' => 'channel_type_id',
            'className' => 'DBModel.Bridges'
        ]);
        $this->hasMany('ChannelTypeProperties', [
            'foreignKey' => 'channel_type_id',
            'className' => 'DBModel.ChannelTypeProperties'
        ]);
        $this->hasMany('ChannelTypeRoles', [
            'foreignKey' => 'channel_type_id',
            'className' => 'DBModel.ChannelTypeRoles'
        ]);
        $this->hasMany('Channels', [
            'foreignKey' => 'channel_type_id',
            'className' => 'DBModel.Channels'
        ]);
        $this->hasMany('HandlerPatterns', [
            'foreignKey' => 'channel_type_id',
            'className' => 'DBModel.HandlerPatterns'
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
            ->integer('concurrency')
            ->allowEmpty('concurrency');

        $validator
            ->allowEmpty('managed');

        $validator
            ->allowEmpty('content');

        $validator
            ->allowEmpty('drift_rules');

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
        $rules->add($rules->existsIn(['process_id'], 'Processes'));
        $rules->add($rules->existsIn(['failure_def_process_id'], 'FailureDefProcesses'));
        $rules->add($rules->existsIn(['provision_def_process_id'], 'ProvisionDefProcesses'));
        $rules->add($rules->existsIn(['post_def_process_id'], 'PostDefProcesses'));
        $rules->add($rules->existsIn(['removal_def_process_id'], 'RemovalDefProcesses'));
        $rules->add($rules->existsIn(['ref_channel_id'], 'RefChannels'));
        $rules->add($rules->existsIn(['pack_id'], 'Packs'));
        return $rules;
    }
}
