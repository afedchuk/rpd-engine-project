<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\AnalyzerMap;
use DBModel\Model\Table\AppTable;

/**
 * AnalyzerMaps Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Uris
 * @property \Cake\ORM\Association\BelongsTo $Analyzers
 */
class AnalyzerMapsTable extends AppTable
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

        $this->table('analyzer_maps');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Uris', [
            'foreignKey' => 'uri_id',
            'className' => 'DBModel.Uris'
        ]);
        $this->belongsTo('Analyzers', [
            'foreignKey' => 'analyzer_id',
            'className' => 'DBModel.Analyzers'
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
        $rules->add($rules->existsIn(['analyzer_id'], 'Analyzers'));
        return $rules;
    }
}
