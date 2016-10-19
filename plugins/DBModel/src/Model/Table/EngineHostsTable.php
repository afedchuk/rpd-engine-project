<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\Event\Event, ArrayObject;
use DBModel\Model\Entity\EngineHost;
use DBModel\Model\Table\AppTable;


/**
 * EngineHosts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Zones
 */
class EngineHostsTable extends AppTable
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
		
		$this->Prefs = TableRegistry::get('DBModel.Prefs'); 
        $this->table('engine_hosts');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Zones', [
            'foreignKey' => 'zone_id'
        ]);
        $this->hasMany('Engines', [
            'dependent' => true,
            'className' => 'DBModel.Engines',
            'bindingKey' => [
                'hostname'
            ],
            'foreignKey' => 'hostname'
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
            ->allowEmpty('hostname')
            ->add('hostname', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('session_key');

        $validator
            ->add('max_engines', 'valid', ['rule' => 'numeric'])
            ->notEmpty('max_engines');

        $validator
            ->add('zone_id', 'valid', ['rule' => 'numeric'])
            ->notEmpty('zone_id');

        $validator
            ->add('gmt_expires', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('gmt_expires');

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
        $rules->add($rules->isUnique(['hostname']));
        return $rules;
    }


    /**
     * Updates zombie counter
     *
     * @param string $hostname hostname of the Engine
     * @param int $zombieCheck zombie check property
     * @return bool
     */

    public function tick(string $hostname, int $zombieCheck = 300)
    {
        $result = $this->find()
                    ->where(['hostname' => $hostname, 'gmt_expires <' => time()])
                    ->first();
        if($result !== null){
            $entity = $this->get($result->id);
            $entity->set('gmt_expires', time() + $zombieCheck);
            if(!$this->save($entity)) {
                return $entity->errors();
            }
            return true;
        }
        return false;
    }

    /**
     * Register engine host in DB or check our session key with the host master
     *
     *@param string $key session key.
     *@return bool
     */
    public function register(string $key = null)
    {
        if($key !== null) {
            $exist = $this->find()->where(['hostname' => php_uname('n')])->first();
            if($exist != null) {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
    * Checks for zombies
    * @return array $engineIds engine ids
    **/
    public function pulseCheck(int $zombieCheck = 300)
    {
        $engineIds = [];
        $engineHosts = $this->find('all')
            ->contain(['Engines', 'Engines.Tasks'])
            ->toArray();
        if(!empty($engineHosts)) {
            foreach ($engineHosts  as $key => $value) {
                if(!empty($value->engines)) {
                    foreach ($value->engines as $engine) {
                        if(($value->gmt_expires + (2*$zombieCheck)) < time() || ($value->session_key != $engine->host_session_key) || 
                            (($engine->activity == 'Idle') && ($engine->gmt_expires < time()))) {
                            $engineIds['clean'][] = $engine->id;
                        } elseif($engine->gmt_expires < time()) {
                            $engineIds['assign'][] = $engine->id;
                        }
                    }
                }
            }
        }
        return $engineIds;
    }

}
?>
