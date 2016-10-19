<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Uri;
use DBModel\Model\Table\AppTable;

/**
 * Uris Model
 *
 * @property \Cake\ORM\Association\BelongsTo $AssetProperties
 * @property \Cake\ORM\Association\BelongsTo $Bridges
 * @property \Cake\ORM\Association\BelongsTo $Assets
 * @property \Cake\ORM\Association\HasMany $AnalyzerMaps
 * @property \Cake\ORM\Association\HasMany $ArtifactProperties
 * @property \Cake\ORM\Association\HasMany $SolidPatterns
 * @property \Cake\ORM\Association\HasMany $Solids
 * @property \Cake\ORM\Association\HasMany $UriDepends
 * @property \Cake\ORM\Association\HasMany $UriProperties
 */
class UrisTable extends AppTable
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

        $this->table('uris');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('AssetProperties', [
            'foreignKey' => 'asset_property_id',
            'className' => 'DBModel.AssetProperties'
        ]);
        $this->belongsTo('Bridges', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.Bridges'
        ]);
        $this->belongsTo('Assets', [
            'foreignKey' => 'asset_id',
            'className' => 'DBModel.Assets'
        ]);
        $this->hasMany('AnalyzerMaps', [
            'foreignKey' => 'uri_id',
            'className' => 'DBModel.AnalyzerMaps'
        ]);
        $this->hasMany('ArtifactProperties', [
            'foreignKey' => 'uri_id',
            'className' => 'DBModel.ArtifactProperties'
        ]);
        $this->hasMany('SolidPatterns', [
            'foreignKey' => 'uri_id',
            'className' => 'DBModel.SolidPatterns'
        ]);
        $this->hasMany('Solids', [
            'foreignKey' => 'uri_id',
            'className' => 'DBModel.Solids'
        ]);
        $this->hasMany('UriDepends', [
            'foreignKey' => 'uri_id',
            'className' => 'DBModel.UriDepends'
        ]);
        $this->hasMany('UriProperties', [
            'foreignKey' => 'uri_id',
            'className' => 'DBModel.UriProperties'
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
            ->allowEmpty('location');

        $validator
            ->allowEmpty('content');

        $validator
            ->allowEmpty('active');

        $validator
            ->allowEmpty('splode');

        $validator
            ->allowEmpty('flag');

        $validator
            ->integer('remote')
            ->allowEmpty('remote');

        $validator
            ->allowEmpty('module_name');

        $validator
            ->integer('sequence')
            ->allowEmpty('sequence');

        $validator
            ->allowEmpty('name');

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
        $rules->add($rules->existsIn(['asset_property_id'], 'AssetProperties'));
        $rules->add($rules->existsIn(['bridge_id'], 'Bridges'));
        $rules->add($rules->existsIn(['asset_id'], 'Assets'));
        return $rules;
    }
	
}
