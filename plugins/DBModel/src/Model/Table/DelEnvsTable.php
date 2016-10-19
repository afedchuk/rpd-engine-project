<?php
namespace DBModel\Model\Table;

use DBModel\Model\Entity\DelEnv;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Table\AppTable;

/**
 * DelEnvs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $NotificationTemplates
 * @property \Cake\ORM\Association\BelongsTo $InitDefProcesses
 * @property \Cake\ORM\Association\BelongsTo $SuccessDefProcesses
 * @property \Cake\ORM\Association\BelongsTo $FailureDefProcesses
 * @property \Cake\ORM\Association\BelongsTo $DriftDefProcesses
 * @property \Cake\ORM\Association\BelongsTo $Deliveries
 * @property \Cake\ORM\Association\BelongsTo $Groups
 * @property \Cake\ORM\Association\HasMany $DelEnvChannels
 * @property \Cake\ORM\Association\HasMany $DelEnvPools
 * @property \Cake\ORM\Association\HasMany $DelEnvProperties
 * @property \Cake\ORM\Association\HasMany $DelEnvRoles
 * @property \Cake\ORM\Association\HasMany $DelEnvSignoffs
 * @property \Cake\ORM\Association\HasMany $DelRoutes
 * @property \Cake\ORM\Association\HasMany $Deliveries
 * @property \Cake\ORM\Association\HasMany $DeliveryPreviews
 * @property \Cake\ORM\Association\HasMany $SpinPreviews
 */
class DelEnvsTable extends AppTable
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

        $this->table('del_envs');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('NotificationTemplates', [
            'foreignKey' => 'notification_template_id'
        ]);
        $this->belongsTo('InitDefProcesses', [
            'foreignKey' => 'init_def_process_id'
        ]);
        $this->belongsTo('SuccessDefProcesses', [
            'foreignKey' => 'success_def_process_id'
        ]);
        $this->belongsTo('FailureDefProcesses', [
            'foreignKey' => 'failure_def_process_id'
        ]);
        $this->belongsTo('DriftDefProcesses', [
            'foreignKey' => 'drift_def_process_id'
        ]);
        $this->belongsTo('Deliveries', [
            'foreignKey' => 'delivery_id'
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
        ]);
        $this->hasMany('DelEnvChannels', [
            'foreignKey' => 'del_env_id'
        ]);
        $this->hasMany('DelEnvPools', [
            'foreignKey' => 'del_env_id'
        ]);
        $this->hasMany('DelEnvProperties', [
            'foreignKey' => 'del_env_id'
        ]);
        $this->hasMany('DelEnvRoles', [
            'foreignKey' => 'del_env_id'
        ]);
        $this->hasMany('DelEnvSignoffs', [
            'foreignKey' => 'del_env_id'
        ]);
        $this->hasMany('DelRoutes', [
            'foreignKey' => 'del_env_id'
        ]);
        $this->hasMany('DeliveryPreviews', [
            'foreignKey' => 'del_env_id'
        ]);
        $this->hasMany('SpinPreviews', [
            'foreignKey' => 'del_env_id'
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
            ->integer('drift_execs_failure')
            ->allowEmpty('drift_execs_failure');

        $validator
            ->integer('protected')
            ->allowEmpty('protected');

        $validator
            ->allowEmpty('content');

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
        $rules->add($rules->existsIn(['notification_template_id'], 'NotificationTemplates'));
        $rules->add($rules->existsIn(['init_def_process_id'], 'InitDefProcesses'));
        $rules->add($rules->existsIn(['success_def_process_id'], 'SuccessDefProcesses'));
        $rules->add($rules->existsIn(['failure_def_process_id'], 'FailureDefProcesses'));
        $rules->add($rules->existsIn(['drift_def_process_id'], 'DriftDefProcesses'));
        $rules->add($rules->existsIn(['delivery_id'], 'Deliveries'));
        $rules->add($rules->existsIn(['group_id'], 'Groups'));
        return $rules;
    }
}
