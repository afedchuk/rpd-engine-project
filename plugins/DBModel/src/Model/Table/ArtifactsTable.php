<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Table\AppTable;

/**
 * Artifacts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ChannelRevs
 * @property \Cake\ORM\Association\BelongsTo $Deliverables
 * @property \Cake\ORM\Association\HasMany $ArtifactFeeds
 * @property \Cake\ORM\Association\HasMany $ArtifactRoles
 * @property \Cake\ORM\Association\HasMany $Deliverables
 * @property \Cake\ORM\Association\HasMany $Solids
 */
class ArtifactsTable extends AppTable
{

    const READY = 'Ready';
    const EMPTY = 'Empty';
    const ERROR = 'Error';
    const CONSTRUCTING = 'Constructing';
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('artifacts');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('ChannelRevs', [
            'foreignKey' => 'channel_rev_id',
            'className' => 'DBModel.ChannelRevs'
        ]);
        $this->belongsTo('Deliverables', [
            'foreignKey' => 'deliverable_id',
            'className' => 'DBModel.Deliverables'
        ]);
        $this->hasMany('ArtifactProperties', [
            'foreignKey' => 'artifact_id',
            'className' => 'DBModel.ArtifactProperties',
            'dependent' => true
        ]);
        $this->hasMany('ArtifactFeeds', [
            'foreignKey' => 'artifact_id',
            'className' => 'DBModel.ArtifactFeeds'
        ]);
        $this->hasMany('ArtifactRoles', [
            'foreignKey' => 'artifact_id',
            'className' => 'DBModel.ArtifactRoles'
        ]);
        $this->hasMany('Deliverables', [
            'foreignKey' => 'artifact_id',
            'className' => 'DBModel.Deliverables'
        ]);
        $this->hasMany('Solids', [
            'foreignKey' => 'artifact_id',
            'className' => 'DBModel.Solids'
        ]);

        $this->addBehavior('DBModel.QTimestamp', [
                'field' => 'gmt_created',
                'events' => [
                    'Artifacts.gmt_created' => [
                        'gmt_created' => 'always'
                    ]
                ]
            ]
        );
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
            ->integer('nextrev')
            ->allowEmpty('nextrev');

        $validator
            ->allowEmpty('revision');

        $validator
            ->integer('gmt_created')
            ->allowEmpty('gmt_created');

        $validator
            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['channel_rev_id'], 'ChannelRevs'));
        $rules->add($rules->existsIn(['deliverable_id'], 'Deliverables'));
        return $rules;
    }

     /**
     * Returns the highest parent.
     *
     * @param int $artifactId artifact id
     * @return int
     */
    public function getHighestParent(int $artifactId)
    {
        $artifact = $this
            ->findById($artifactId)
            ->first();
        if ($artifact['ref_artifact_id'] > 0) {
            return $this->getHighestParent($artifact['ref_artifact_id']);
        } else {
            return $artifact['id'];
        }
    }

    /**
     * Returns an array of all properties for the artifact.
     *
     * @param int $id artifact id
     * @param bool $includeParent include parent or not
     * @return string
     */
    public function getParentStatus(int $id)
    {   
        $parentId = $this->getHighestParent($id);
        if($parentId == $id){
            return false;
        }
        $statusList = $this
                    ->find('list', ['keyField' => 'id' , 'valueField' => 'status'])
                    ->where(['ref_artifact_id' => $parentId])
                    ->toArray();
        $resultStatus = $this->filterStatuses(array_unique($statusList));
        return $resultStatus;        
    }
  
   /**
     * Set Artifact and Deliverable statuses when populating Solids
     *
     * @param int $artifactId Artifact ID
     * @return string
     */

    public function setArtifactAndDeliverableStatus(int $artifactId)
    {
        $statusList = array_unique($this->Solids->getSolidsRecursively($artifactId, 'status', [], true));
       
        $resultStatus = $this->filterStatuses($statusList);

        $artifactEntity = $this->setArtifactStatus($artifactId, $resultStatus); 

        if($artifactEntity !== false) {
           $this->setInitDelivarableStatus($artifactEntity->deliverable_id,  $resultStatus); 
           // if parent exist -  set status
           $parentId = $this->getHighestParent($artifactId);
           if($parentId !== $artifactId ){
              $this->setArtifactStatus( $parentId, $this->getParentStatus($artifactId)); 
           }
        }
        return $resultStatus;

    }

      /**
     * Set initial Deliverable statuses when solids are populated
     *
     * @param int $deliverableId Deliverable ID
     * @param int $artifactId Artifact ID
     * @return bool
     */

    public function setInitDelivarableStatus(int $deliverableId, string $resultStatus)
    {
        if(!$deliverableId){
            return false;
        }
        $deliverableEntity = $this->Deliverables->get($deliverableId);
        $deliverableEntity->status = ( $resultStatus == SELF::ERROR ) ?   $resultStatus : DeliverablesTable::CONSTRUCT; // since we have different status in 
                                                                                                      //Deliverables and Artifact (Construct and Constructing respectively)
                                                                                                      //we should do this condition check. But we can change anytime the statuses names
        return $this->Deliverables->save($deliverableEntity) ? true: $this->errors();
    }

     /**
     * Filtering status for Artifacts and Deliverables
     *
     * @param array $statusList list of statuses that solids have in artifact
     * @return string
     */


    public function filterStatuses(array $statusList, $resultStatus = SELF::CONSTRUCTING )
    {   
        if (empty($statusList)) {
            $resultStatus = SELF::EMPTY;
        }else if (in_array(SELF::ERROR, $statusList)) {
            $resultStatus = SELF::ERROR;
        }else if (count($statusList) == 1 && reset($statusList) == SELF::READY) {
            $resultStatus = SELF::READY;
        }
        return $resultStatus;
    }

    /**
     * setting artifact status
     *
     * @param array $statusList list of statuses that solids have in artifact
     * @return obj
     */

    public function setArtifactStatus(int $artifactId, string $status)
    {  
      $artifactEntity = $this->findById($artifactId)->first();
      if(!$artifactEntity){
        return false;
      }
      $artifactEntity->status = $status;
      if(!$this->save($artifactEntity)){
        $this->errors();
      }
      return $artifactEntity;
    }
}