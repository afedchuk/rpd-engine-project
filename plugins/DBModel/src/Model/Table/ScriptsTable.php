<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Script;
use DBModel\Model\Table\AppTable;
use DBModel\Model\Table\BridgesTable;
use Cake\ORM\TableRegistry;

/**
 * Scripts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $References
 * @property \Cake\ORM\Association\BelongsTo $Platforms
 * @property \Cake\ORM\Association\BelongsTo $Packs
 *
 * @method \DBModel\Model\Entity\Script get($primaryKey, $options = [])
 * @method \DBModel\Model\Entity\Script newEntity($data = null, array $options = [])
 * @method \DBModel\Model\Entity\Script[] newEntities(array $data, array $options = [])
 * @method \DBModel\Model\Entity\Script|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \DBModel\Model\Entity\Script patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \DBModel\Model\Entity\Script[] patchEntities($entities, array $data, array $options = [])
 * @method \DBModel\Model\Entity\Script findOrCreate($search, callable $callback = null)
 */
class ScriptsTable extends AppTable
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

        $this->table('scripts');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('References', [
            'foreignKey' => 'reference_id',
            'className' => 'DBModel.References'
        ]);
        $this->belongsTo('Platforms', [
            'foreignKey' => 'platform_id',
            'className' => 'DBModel.Platforms'
        ]);
        $this->belongsTo('Packs', [
            'foreignKey' => 'pack_id',
            'className' => 'DBModel.Packs'
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
            ->integer('gmt_created')
            ->allowEmpty('gmt_created');

        $validator
            ->integer('version')
            ->allowEmpty('version');

        $validator
            ->allowEmpty('activ');

        $validator
            ->allowEmpty('name');

        $validator
            ->allowEmpty('md5');

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
        $rules->add($rules->existsIn(['reference_id'], 'References'));
        $rules->add($rules->existsIn(['platform_id'], 'Platforms'));
        $rules->add($rules->existsIn(['pack_id'], 'Packs'));

        return $rules;
    }

    /**
     * getScriptForBridge 
     * @param  string scriptName Name of script to find
     * @param  string bridgeId Bridge Id I will need a script for
     * @return Entity | false script
     */
    public function getScriptForBridge(string $scriptName, int $bridgeId)
    {
        $this->Bridges = TableRegistry::get('Bridges');
        try {
            $bridge = $this->Bridges->get($bridgeId);
            if ($bridge) {
                $platform = [];
                if($bridge->remote_platform === 'Unknown') {
                    $pl = $this->Platforms->findByName($bridge->platform)->first();
                    $platform['id'] = strval($pl->id);
                } else {
                    $platform['id'] = $bridge->remote_platform;
                }
                // Get Windows if 110 or Any Linux
                if(!in_array($platform['id'], ['110', '111'])) {
                    $platform['id'] = 0;
                    $platform['name'] = 'any platform';
                } else {
                    $platform['id'] = 110;
                    $platform['name'] = 'Windows';
                }
                // look for script names that are dispacher-like
                $specificPack = 1; // This is for generic package
                if(strncmp($scriptName,"dispatch_",9) == 0 || preg_match('/^.*?@dispatch_.*/',$scriptName)) {
                    $specificPack = 105;
                    $isDispatcherScript = true;
                    if( $scriptName == "dispatch_srun") {
                        $platform['id'] = 0;
                        $platform['name'] = 'nsh';
                    }
                }
                $script = $this
                            ->find()
                            ->where(['name' => $scriptName, 
                                            'activ' => 'y', 
                                            'platform_id' => $platform['id'], 
                                            'pack_id' => $specificPack])
                            ->first();
                $script['platform'] = $platform;
                return $script;
            }
        } catch(\Exception $e) {
            return false;
        }
    }
}
