<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
use DBModel\Model\Entity\Toc;

/**
 * Tocs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Solids
 */
class TocsTable extends AppTable
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

        $this->table('tocs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Solids', [
            'foreignKey' => 'solid_id',
            'className' => 'DBModel.Solids'
        ]);

         $this->addBehavior('DBModel.DefaultFields', [
            'fields' => [
                ['field' => 'typ', 'value' => 'F']
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('count')
            ->requirePresence('count', 'create')
            ->notEmpty('count');

        $validator
            ->allowEmpty('typ');

        $validator
            ->allowEmpty('path');

        $validator
            ->allowEmpty('md5');

        $validator
            ->integer('siz')
            ->requirePresence('siz', 'create')
            ->notEmpty('siz');

        $validator
            ->integer('offset')
            ->allowEmpty('offset');

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
        return $rules;
    }

    /**
    * Writing toc info after file received
    * @param array $entry toc data
    * @param array $header file info
    * @param int $ftell file pointer
    * @return bool | DBModel\Model\Entity\Toc errors
    **/
    public function flushTocCreate(array $entry, array $header, int $ftell)
    {
        $toc = $this->newEntity([
                'solid_id' => $entry['solid_id'],'typ' => trim($header[0]),
                'siz' => $header[1],'md5' => $header[2],
                'path' => $header[3], 'count' => count($entry['toc']),
            ]
        );
        if($this->save($toc)) {
            $offset = '"offset"';
            if(preg_match('/Oracle/', ConnectionManager::get('default')->config()['driver'])) {
                $offset = trim($offset, '"');
            }
            $this->updateAll([$offset => $ftell], ['id' => $this->getInsertID()]);
        } else {
            return $toc->errors();
        }
        return true;
    }

    /**
    * Check to see if it exists, and store info on getting to it if it does.
    *
    * @param array $params file data
    * @return array solid data
    **/
    public function locateExistingFile(array $params, int $threshold) {
        // gonna pull from the existing copy
        $matches = $this->find()
            ->where(['Tocs.md5' => $params['md5'], 'Tocs.siz' => $params['siz'], 'Tocs.count' => 1])
            ->contain(['Solids'])
            ->first();  

        if ($threshold == 0 || $params['siz'] < $threshold || $matches === null) {
            return [];
        }

        // get the first artifact id that references this solid
        $reference = $this->Solids->find('all')
            ->where(['Solids.reference_id' => $matches->solid_id, 'Solids.status' => 'Ready'])
            ->contain(['ArtifactDeliverables'])
            ->first();

        if (isset($reference) && $reference->artifact_deliverable !== null) {
            if(isset($reference->artifact_deliverable->artifact_name)) {
                $matches['artifact_name'] = $reference->artifact_deliverable->artifact_name . ":" . $reference->artifact_deliverable->name;
            }
        } else {
            $matches['artifact_name'] = $matches->solid->name;
        }
        return $matches;
    }
}
