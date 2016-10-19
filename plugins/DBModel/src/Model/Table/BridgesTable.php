<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Bridge;
use DBModel\Model\Table\AppTable;
use Cake\ORM\TableRegistry;

/**
 * Bridges Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Zones
 * @property \Cake\ORM\Association\BelongsTo $Vms
 * @property \Cake\ORM\Association\BelongsTo $ChannelTypes
 * @property \Cake\ORM\Association\HasMany $ArtifactFeeds
 * @property \Cake\ORM\Association\HasMany $BridgeProperties
 * @property \Cake\ORM\Association\HasMany $BridgeRoles
 * @property \Cake\ORM\Association\HasMany $ChannelRevs
 * @property \Cake\ORM\Association\HasMany $Channels
 * @property \Cake\ORM\Association\HasMany $Solids
 * @property \Cake\ORM\Association\HasMany $Tasks
 * @property \Cake\ORM\Association\HasMany $Uris
 */
class BridgesTable extends AppTable
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

        $this->table('bridges');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Zones', [
            'foreignKey' => 'zone_id',
            'className' => 'DBModel.Zones'
        ]);
        $this->belongsTo('Vms', [
            'foreignKey' => 'vm_id',
            'className' => 'DBModel.Vms'
        ]);
        $this->belongsTo('ChannelTypes', [
            'foreignKey' => 'channel_type_id',
            'className' => 'DBModel.ChannelTypes'
        ]);
        $this->hasMany('ArtifactFeeds', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.ArtifactFeeds'
        ]);
        $this->hasMany('BridgeProperties', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.BridgeProperties',
            'dependent' => true
        ]);
        $this->hasMany('BridgeRoles', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.BridgeRoles'
        ]);
        $this->hasMany('ChannelRevs', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.ChannelRevs'
        ]);
        $this->hasMany('Channels', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.Channels'
        ]);
        $this->hasMany('Solids', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.Solids'
        ]);
        $this->hasMany('Tasks', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.Tasks'
        ]);
        $this->hasMany('Uris', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.Uris'
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
            ->integer('agent_writable')
            ->allowEmpty('agent_writable');

        $validator
            ->integer('agent_up')
            ->allowEmpty('agent_up');

        $validator
            ->allowEmpty('agent_info');

        $validator
            ->allowEmpty('remote_platform');

        $validator
            ->allowEmpty('platform');

        $validator
            ->allowEmpty('despatcher');

        $validator
            ->allowEmpty('hostname')
            ->add('hostname', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

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
        $rules->add($rules->isUnique(['hostname']));
        $rules->add($rules->existsIn(['zone_id'], 'Zones'));
        $rules->add($rules->existsIn(['vm_id'], 'Vms'));
        $rules->add($rules->existsIn(['channel_type_id'], 'ChannelTypes'));
        return $rules;
    }

    public function getValidServers()
    {
        $query = $this->find('list', ['keyField' => 'id', 'valueField' => 'id'])->contain([]);
        return $query->toArray();
    }

    /**
     * Return a set of servers that belongs to given zone.
     *
     * @return array zone ids
     */
    public function getZoneServerList ()
    {
        $this->Engines = TableRegistry::get('Engines', ['className' => 'DBModel\Model\Table\EnginesTable']);
        $myZone = $this->Engines->getMyZone(get('engineId')); // find out which zone current engine belongs to
            $validBridgeSet = $this
                                ->find('list')
                                ->select(['id'])
                                ->where(['zone_id'=> ($myZone) ? $myZone->id : 0])
                                ->toArray(); // get a valid servers set for current engine
        $validBridgeSet += [0]; // push extra bridge to be able to work on null refs and remote refs.
        return $validBridgeSet;
    }
}
