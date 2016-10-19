<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Channel;
use DBModel\Model\Table\AppTable;

/**
 * Channels Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ChannelTypes
 * @property \Cake\ORM\Association\BelongsTo $OwnerProcesses
 * @property \Cake\ORM\Association\BelongsTo $ChannelRevs
 * @property \Cake\ORM\Association\BelongsTo $Bridges
 * @property \Cake\ORM\Association\BelongsTo $Lbs
 * @property \Cake\ORM\Association\BelongsTo $ChannelConfs
 * @property \Cake\ORM\Association\BelongsTo $ChannelPropertySets
 * @property \Cake\ORM\Association\HasMany $ArtifactFeeds
 * @property \Cake\ORM\Association\HasMany $BuildCheckouts
 * @property \Cake\ORM\Association\HasMany $ChannelProcesses
 * @property \Cake\ORM\Association\HasMany $ChannelRevs
 * @property \Cake\ORM\Association\HasMany $ChannelRoles
 * @property \Cake\ORM\Association\HasMany $DelEnvChannels
 * @property \Cake\ORM\Association\HasMany $DelEnvPoolChannels
 * @property \Cake\ORM\Association\HasMany $DeliveryChannels
 * @property \Cake\ORM\Association\HasMany $DeliveryProcesses
 */
class ChannelsTable extends AppTable
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

        $this->table('channels');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('ChannelTypes', [
            'foreignKey' => 'channel_type_id',
            'className' => 'DBModel.ChannelTypes'
        ]);
        $this->belongsTo('OwnerProcesses', [
            'foreignKey' => 'owner_process_id',
            'className' => 'DBModel.OwnerProcesses'
        ]);
        $this->belongsTo('ChannelRevs', [
            'foreignKey' => 'channel_rev_id',
            'className' => 'DBModel.ChannelRevs'
        ]);
        $this->belongsTo('Bridges', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.Bridges'
        ]);
        $this->belongsTo('Lbs', [
            'foreignKey' => 'lb_id',
            'className' => 'DBModel.Lbs'
        ]);
        $this->belongsTo('ChannelConfs', [
            'foreignKey' => 'channel_conf_id',
            'className' => 'DBModel.ChannelConfs'
        ]);
        $this->belongsTo('ChannelPropertySets', [
            'foreignKey' => 'channel_property_set_id',
            'className' => 'DBModel.ChannelPropertySets'
        ]);
        $this->hasMany('ArtifactFeeds', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.ArtifactFeeds'
        ]);
        $this->hasMany('BuildCheckouts', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.BuildCheckouts'
        ]);
        $this->hasMany('ChannelProcesses', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.ChannelProcesses'
        ]);
        $this->hasMany('ChannelRevs', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.ChannelRevs'
        ]);
        $this->hasMany('ChannelRoles', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.ChannelRoles'
        ]);
        $this->hasMany('DelEnvChannels', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.DelEnvChannels'
        ]);
        $this->hasMany('DelEnvPoolChannels', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.DelEnvPoolChannels'
        ]);
        $this->hasMany('DeliveryChannels', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.DeliveryChannels'
        ]);
        $this->hasMany('DeliveryProcesses', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.DeliveryProcesses'
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
        $rules->add($rules->existsIn(['channel_type_id'], 'ChannelTypes'));
        $rules->add($rules->existsIn(['owner_process_id'], 'OwnerProcesses'));
        $rules->add($rules->existsIn(['channel_rev_id'], 'ChannelRevs'));
        $rules->add($rules->existsIn(['bridge_id'], 'Bridges'));
        $rules->add($rules->existsIn(['lb_id'], 'Lbs'));
        $rules->add($rules->existsIn(['channel_conf_id'], 'ChannelConfs'));
        $rules->add($rules->existsIn(['channel_property_set_id'], 'ChannelPropertySets'));
        return $rules;
    }
}
