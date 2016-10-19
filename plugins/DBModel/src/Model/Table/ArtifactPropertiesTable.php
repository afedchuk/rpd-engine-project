<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\ArtifactProperty;
use DBModel\Model\Table\AppTable;

/**
 * ArtifactProperties Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Uris
 * @property \Cake\ORM\Association\BelongsTo $Artifacts
 */
class ArtifactPropertiesTable extends AppTable
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

        $this->table('artifact_properties');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Uris', [
            'foreignKey' => 'uri_id',
            'className' => 'DBModel.Uris'
        ]);
        $this->belongsTo('Artifacts', [
            'foreignKey' => 'artifact_id',
            'className' => 'DBModel.Artifacts'
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
            ->integer('locked')
            ->allowEmpty('locked');

        $validator
            ->allowEmpty('name');

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('value');

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
        $rules->add($rules->existsIn(['uri_id'], 'Uris'));
        $rules->add($rules->existsIn(['artifact_id'], 'Artifacts'));
        return $rules;
    }
}
