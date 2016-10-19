<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Table\AppTable;
use DBModel\Model\Entity\Analyzer;

/**
 * Analyzers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Modules
 */
class AnalyzersTable extends AppTable
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

        $this->table('analyzers');
        $this->displayField('name');
        $this->primaryKey([ 'id']);

        $this->hasMany('AnalyzerMaps', [
            'foreignKey' => 'analyzer_id',
            'dependent' => true,
            'className' => 'DBModel.AnalyzerMaps',
        ]);
        $this->hasMany('AnalyzerProperties', [
            'className' => 'DBModel.AnalyzerProperties',
            'dependent' => true,
            'foreignKey' => 'analyzer_id'
        ]);
        $this->hasMany('SolidAnalyzerMaps', [
            'dependent' => true,
            'className' => 'DBModel.SolidAnalyzerMaps',
            'foreignKey' => 'analyzer_id'
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Analyzer name already exists.'])
            ->notEmpty('name');

        $validator
            ->notEmpty('module');

        $validator
            ->allowEmpty('copy_on_explode');

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
        $rules->add($rules->existsIn(['module'], 'Modules'));
        return $rules;
    }

}
