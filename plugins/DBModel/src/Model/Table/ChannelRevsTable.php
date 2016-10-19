<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChannelRevs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Channels
 * @property \Cake\ORM\Association\BelongsTo $Bridges
 * @property \Cake\ORM\Association\HasMany $Artifacts
 * @property \Cake\ORM\Association\HasMany $ChannelConfs
 * @property \Cake\ORM\Association\HasMany $ChannelPropertySets
 * @property \Cake\ORM\Association\HasMany $Channels
 * @property \Cake\ORM\Association\HasMany $Tasks
 *
 * @method \DBModel\Model\Entity\ChannelRev get($primaryKey, $options = [])
 * @method \DBModel\Model\Entity\ChannelRev newEntity($data = null, array $options = [])
 * @method \DBModel\Model\Entity\ChannelRev[] newEntities(array $data, array $options = [])
 * @method \DBModel\Model\Entity\ChannelRev|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DBModel\Model\Entity\ChannelRev patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \DBModel\Model\Entity\ChannelRev[] patchEntities($entities, array $data, array $options = [])
 * @method \DBModel\Model\Entity\ChannelRev findOrCreate($search, callable $callback = null)
 */
class ChannelRevsTable extends Table
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

        $this->table('channel_revs');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Channels', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.Channels'
        ]);
        $this->belongsTo('Bridges', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.Bridges'
        ]);
        $this->hasMany('Artifacts', [
            'foreignKey' => 'channel_rev_id',
            'className' => 'DBModel.Artifacts'
        ]);
        $this->hasMany('ChannelConfs', [
            'foreignKey' => 'channel_rev_id',
            'className' => 'DBModel.ChannelConfs'
        ]);
        $this->hasMany('ChannelPropertySets', [
            'foreignKey' => 'channel_rev_id',
            'className' => 'DBModel.ChannelPropertySets'
        ]);
        $this->hasMany('Channels', [
            'foreignKey' => 'channel_rev_id',
            'className' => 'DBModel.Channels'
        ]);
        $this->hasMany('Tasks', [
            'foreignKey' => 'channel_rev_id',
            'className' => 'DBModel.Tasks'
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
            ->integer('sequence')
            ->allowEmpty('sequence');

        $validator
            ->integer('gmt_created')
            ->allowEmpty('gmt_created');

        $validator
            ->allowEmpty('name');

        $validator
            ->allowEmpty('state');

        $validator
            ->allowEmpty('ref_state');

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
        $rules->add($rules->existsIn(['channel_id'], 'Channels'));
        $rules->add($rules->existsIn(['bridge_id'], 'Bridges'));

        return $rules;
    }
}
