<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Solid;
use DBModel\Model\Table\AppTable;

/**
 * Solids Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Deliverables
 * @property \Cake\ORM\Association\BelongsTo $Engines
 * @property \Cake\ORM\Association\BelongsTo $Uris
 * @property \Cake\ORM\Association\BelongsTo $Deliveries
 * @property \Cake\ORM\Association\BelongsTo $References
 * @property \Cake\ORM\Association\BelongsTo $Bridges
 * @property \Cake\ORM\Association\BelongsTo $Artifacts * @property \Cake\ORM\Association\HasMany $ArtifactFeeds
 * @property \Cake\ORM\Association\HasMany $Blobs
 * @property \Cake\ORM\Association\HasMany $BuildCheckouts
 * @property \Cake\ORM\Association\HasMany $DeliveryProcesses
 * @property \Cake\ORM\Association\HasMany $SolidAnalyzerMaps
 * @property \Cake\ORM\Association\HasMany $SolidDepends
 * @property \Cake\ORM\Association\HasMany $Tocs
 */
class SolidsTable extends AppTable
{
    const READY = 'Ready';
    const ERROR = 'Error';
    const FETCHING = 'Fetching';
    const PROCESSING = 'Processing';

    protected $consistency =  ['conditions' => [['engine_id !=' => 0 ], ['engine_id' => '0', 'gmt_fetched >' => 1, 'analyz' => 'n', 'artifact_id >' => 0, 'status' => self::PROCESSING]], 'data' => ['engine_id' => 0 ]];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('solids');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Deliverables', [
            'foreignKey' => 'deliverable_id',
            'className' => 'DBModel.Deliverables'
        ]);
        $this->belongsTo('ArtifactDeliverables', [
            'foreignKey' => 'artifact_id',
            'bindingKey' => [
                'artifact_id'
            ],
            'className' => 'DBModel.Deliverables'
        ]);
        $this->belongsTo('Engines', [
            'foreignKey' => 'engine_id',
            'className' => 'DBModel.Engines'
        ]);
        $this->belongsTo('Uris', [
            'foreignKey' => 'uri_id',
            'className' => 'DBModel.Uris'
        ]);
        $this->belongsTo('Deliveries', [
            'foreignKey' => 'delivery_id',
            'className' => 'DBModel.Deliveries'
        ]);
        $this->belongsTo('Bridges', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.Bridges'
        ]);
        $this->belongsTo('Artifacts', [
            'foreignKey' => 'artifact_id',
            'className' => 'DBModel.Artifacts'
        ]);
        $this->hasMany('ArtifactFeeds', [
            'foreignKey' => 'solid_id',
            'dependent' => true,
            'className' => 'DBModel.ArtifactFeeds'
        ]);
        $this->hasMany('Blobs', [
            'foreignKey' => 'solid_id',
            'className' => 'DBModel.Blobs'
        ]);
        $this->hasMany('BuildCheckouts', [
            'foreignKey' => 'solid_id',
            'className' => 'DBModel.BuildCheckouts'
        ]);
        $this->hasMany('DeliveryProcesses', [
            'foreignKey' => 'solid_id',
            'className' => 'DBModel.DeliveryProcesses'
        ]);
        $this->hasMany('SolidAnalyzerMaps', [
            'foreignKey' => 'solid_id',
            'className' => 'DBModel.SolidAnalyzerMaps'
        ]);
        $this->hasMany('SolidDepends', [
            'foreignKey' => 'solid_id',
            'className' => 'DBModel.SolidDepends'
        ]);
        $this->hasMany('Tocs', [
            'foreignKey' => 'solid_id',
            'className' => 'DBModel.Tocs'
        ]);
        $this->hasMany('ReferenceTocs', [
            'foreignKey' => 'solid_id',
            'bindingKey' => [
                'reference_id'
            ],
            'className' => 'DBModel.Tocs'
        ]);

        $this->addBehavior('DBModel.DefaultFields', [
            'fields' => [
                ['field' => 'reference_id', 'value' => 0],
                ['field' => 'module_name', 'value' => 'exploder'],
                ['field' => 'status', 'value' => 'Processing'],
                ['field' => 'analyz', 'value' => 'y'],
                ['field' => 'uri_id', 'value' => 0],
                ['field' => 'engine_id', 'value' => 0],
                ['field' => 'gmt_fetched', 'value' => time()]
            ]
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
            ->integer('uri_require')
            ->allowEmpty('uri_require');

        $validator
            ->allowEmpty('remote_location');

        $validator
            ->allowEmpty('content');

        $validator
            ->allowEmpty('meta');

        $validator
            ->allowEmpty('stamp');

        $validator
            ->allowEmpty('active');

        $validator
            ->allowEmpty('splode');

        $validator
            ->allowEmpty('md5');

        $validator
            ->allowEmpty('toc');

        $validator
            ->allowEmpty('analyz');

        $validator
            ->allowEmpty('reference_id');

        $validator
            ->integer('gmt_fetched')
            ->allowEmpty('gmt_fetched');

        $validator
            ->notEmpty('status');

        $validator
            ->integer('pct')
            ->allowEmpty('pct');

        $validator
            ->integer('siz')
            ->allowEmpty('siz');

        $validator
            ->allowEmpty('module_name');

        $validator
            ->allowEmpty('store_uri');

        $validator
            ->allowEmpty('location');

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
        $check = function($entity){
            if($entity->status == 'Ready'){
                $entity->gmt_fetched = time();
            }
            return true;
            
        };
        $rules->add($check, []);
        return $rules;
    }

    /**
     * Update a solid master status and all the reference solids
     *
     * @param  int $solidId solid id.
     * @param  int $pct.
     * @param  string $status solid status.
     * @return bool true|false
     */
    public function setSolidStatus(int $solidId, int $pct, string $status) 
    {
        if($solidId > 0) {
            $referenceId = $this->get($solidId)->reference_id;
            $this->removeBehavior('DefaultFields');
            $this->updateAll(['pct' => $pct, 'status' => $status], ['reference_id' => $referenceId]);
            if(!in_array($status, [self::ERROR])) {
                if($this->updateAll(['pct' => $pct, 'status' => $status], ['id' => $referenceId])) {
                   return true;
                }
            } else {
                if($this->updateAll(['pct' => $pct, 'analyz' => 'n', 'status' => $status], ['id' => $referenceId])) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Get a solid record by id or reference id
     *
     * @param  int $id solid id.
     * @return array
     */
    public function getRecursiveSolidById(int &$id)
    {
        $solid = $this->get($id, ['contain' => ['Artifacts', 'SolidDepends', 'Uris']])->toArray();
        if(!empty($solid) && $solid['reference_id'] > 0 && ($id = $solid['reference_id'])) {
            return $this->getRecursiveSolidById($solid['reference_id']);
        }
        return $solid;
    }

    /**
    * We'll create a new master/slave solid and populate it with translated entries.
    * The new master and slave will have the original sequence number so it will be in the same place.
    *
    * @param array $data solid data
    * @param bool $behavior remove DefaultFields bevavior 
    * @return int solid masted id | \DBModel\Model\Entity\Solid validation errors
    **/
    public function populateMasterSlaveSolid(array $data, bool $behavior = true)
    {
        !$behavior && $this->removeBehavior('DefaultFields');
        if(!empty($data)) {
            $entityMaster = $this->newEntity($data);
            if($this->save($entityMaster)) {    
                $idMaster = $this->getInsertID();
                $entityDummy = $this->newEntity($data);
                if($this->save($entityDummy)) {
                    $slaveId = $this->getInsertID();
                    $this->updateAll(['reference_id' => $idMaster], ['id' => $slaveId]);
                } else {
                    return  $entityDummy->errors();
                }
            } else {
                return $entityMaster->errors();
            }
        }
        return $idMaster;
    }

    /**
     * Consistency hook
     *
     * @param array $item table data
     * @return void
     */
    public function consistencyHook(\DBModel\Model\Entity\Solid $item)
    {
        
        $this->setSolidStatus($item->id, '100', self::READY);
        $this->Artifacts->setArtifactAndDeliverableStatus($item->artifact_id);
    }

    /**
     * Returns an array of solids.
     *
     * @param int $id artifact id
     * @param string | array $field filed(fields) name
     * @param array $$solidsArray solids
     * @param bool $includeGroups include groups or not
     * @return array
     */
    public function getSolidsRecursively(int $id, $field, array $solids = [], bool $includeGroups = true)
    {
        $recSolids = [];
        if(empty($solids)) {
            $solids = $this
                            ->findByArtifactId($id)
                            ->toArray();
        }
        foreach ($solids as $solid) {
            if ($solid['ref_artifact_id'] > 0 && $includeGroups) {
                $recSolids = $this->filterArtifactSolid($field, $solid);
                $solids = $this
                                ->findByArtifactId($solid->ref_artifact_id)
                                ->toArray();
                $recSolids += $this->getSolidsRecursively($id, $field, $solids,  $includeGroups);
            } else {
                $recSolids += $this->filterArtifactSolid($field, $solid);
            }
        }
        return $recSolids;
    }

    /**
     * Returns an array of solid records or solid record depending on field attribute.
     *
     * @param string | array $field solid field
     * @param \DBModel\Model\Entity\Solid $solid
     * @return array
     */
    function filterArtifactSolid($field, \DBModel\Model\Entity\Solid $solid)
    {
        $recSolids = [];
        if (is_array($field)) {
            $recSolids[$solid['id']] = [];
            foreach ($field as $f) {
                $recSolids[$solid['id']][$f] = $solid[$f];
            }
        } else {
            $recSolids[$solid['id']] = $solid[$field];
        }
        return $recSolids;
    }
	
     /**
     * Solid population
     *
     * @param int $solidId Solid ID
     * @return \DBModel\Model\Entity\Solid $solid
     */

    public function populateSolid(int $solidId)
    {

        $solid = $this->get($solidId,['contain'=>'Uris']);
        $this->Artifacts->setArtifactAndDeliverableStatus($solid->artifact_id);
        $solid->status = self::FETCHING;
        $solid->store_uri = $this->getSysPref('artifact_store_uri','base64://db');
        $result = $this->save($solid);
        if(!$result){
            return($solid->errors());
        }
        // TO BE CONTINUED...

        return $solid;
    }


     /**
     * Assigns Engine to Solid and updates some data in Solids
     *
     * @param int $solidId Solid ID
     * @return bool | solid entity
     */

    public function updateSolid(int $solidId)
    {
        $solid = $this->get($solidId, ['contain'=>'Uris']);
        // Map refernce_get_whatever module name from URI to asset_action module name
        // this is done do execute SolidAssetActionTask.

        if(preg_match('/^reference_get/', $solid->uri->module_name)) {
            $solid->module_name = 'asset_action';
        } else {
            $solid->module_name = $solid->uri->module_name;
        }
        $solid->bridge_id = $solid->uri->bridge_id;
        return $this->save($solid) ? $solid: false;
    }

     /**
     * Check whether solids have any analyzers assigned to them
     *
     * @param int $artifactId Artifact ID
     * @return bool
     */

    public function hasInstanceSolidsAnyAnalyzers(int $artifactId)
    {   
        $result = $this->find('all', ['conditions' => ['artifact_id' => $artifactId], 'contain' => ['Uris.AnalyzerMaps'] ])->toArray();
        foreach ($result as $solid) {
            if(count($solid->uri->analyzer_maps) > 0){
                return true;
            }
        }
        return false;

    }
}
