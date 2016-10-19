<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\SolidAnalyzerMap;
use DBModel\Model\Table\AppTable;

/**
 * SolidAnalyzerMaps Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Solids
 * @property \Cake\ORM\Association\BelongsTo $Analyzers
 */
class SolidAnalyzerMapsTable extends AppTable
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

        $this->table('solid_analyzer_maps');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Solids', [
            'foreignKey' => 'solid_id',
            'className' => 'DBModel.Solids'
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
        $rules->add($rules->existsIn(['solid_id'], 'Solids'));
        $rules->add($rules->existsIn(['analyzer_id'], 'Analyzers'));
        return $rules;
    }


    /**
     * Analyze solid content for analyzers
     *
     * @param  int $solid solid id.
     * @param  int $artifactId artifact id.
     * @param  int $eventId event id.
     * @return array analyzer data.
     */
    public function analyzeContent(array $solid, int $artifactId, int $eventId = 0) 
    {  
        return $this->find('all')
                ->where(['SolidAnalyzerMaps.solid_id' => $solid['id']])
                ->contain(['Analyzers', 'Analyzers.AnalyzerProperties', 'Solids'])->toArray();
    }

    /**
     * Copy analyzer map solid
     *
     * @param  int $fromSolidId copy from.
     * @param  int $toSolidId copy to.
     * @param  bool $afterSeq sequence number.
     * @return void.
     */
    public function copyMap(int $fromSolidId, int $toSolidId, int $afterSeq = 0, bool $ignoreCopyFlag = false, bool $forceOn = true) 
    {
        $result = $this->find('all', ['order' => ['sequence']])
            ->where(['solid_id' => $fromSolidId])
            ->select(['id', 'analyzer_id'])->toArray();
        if($result) {
            foreach($result as &$analyzer) { 
                $new = $this->newEntity(['solid_id' => $toSolidId, 'analyzer_id' => $analyzer->analyzer_id, 'sequence' => $this->nextSequence(['solid_id' => $toSolidId])]);
                $this->save($new);
            }
            return true;
        }
        return false;
    }


     /**
     * Add solid ID to analyzer
     *
     * @param  obj solid
     * @return bool.
     */
    public function addSolidToAnalyzer(int $solidId)
    {
        $solid = $this->Solids->get($solidId, ['contain'=>['Uris.AnalyzerMaps'] ]);
        $data = [];
        foreach ($solid->uri->analyzer_maps as $item) { 
            $data[] = ['solid_id' => $solid->id,
                       'analyzer_id' => $item->analyzer_id,
                       'sequence' => $item->sequence
                       ];
        }
        $entities = $this->newEntities($data);
        foreach ($entities as $entity) {
            if(!$this->save($entity)){
                return false;
            }
        }
        return true;

    }
}
