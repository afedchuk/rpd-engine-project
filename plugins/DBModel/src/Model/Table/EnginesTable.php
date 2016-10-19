<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Engine;
use DBModel\Model\Table\AppTable;

/**
 * Engines Model
 *
 * @property \Cake\ORM\Association\HasMany $BuildCheckouts
 * @property \Cake\ORM\Association\HasMany $Deliveries
 * @property \Cake\ORM\Association\HasMany $Processes
 * @property \Cake\ORM\Association\HasMany $Solids
 * @property \Cake\ORM\Association\HasMany $Tasks
 */
class EnginesTable extends AppTable
{

    const RESTART = 'Restart';
    const MONITOR = 'Monitor';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('engines');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('BuildCheckouts', [
            'foreignKey' => 'engine_id'
        ]);
        $this->hasMany('Deliveries', [
            'foreignKey' => 'engine_id'
        ]);
        $this->hasMany('Processes', [
            'foreignKey' => 'engine_id'
        ]);
        $this->hasMany('Solids', [
            'foreignKey' => 'engine_id'
        ]);
        $this->hasMany('Tasks', [
            'foreignKey' => 'engine_id'
        ]);
        $this->belongsTo('EngineHosts', [
            'dependent' => true,
            'className' => 'DBModel.EngineHosts',
            'bindingKey' => [
                'hostname'
            ],
            'foreignKey' => 'hostname'
        ]);

        $this->addBehavior('DBModel.DefaultFields', [
                'fields' => [
                    ['field' =>'activity', 'value' => 'Idle'],
                    ['field' => 'control', 'value' => 'Monitor'],
                    ['field' => 'gmt_created', 'value' => time()],
                    ['field' => 'count', 'value' => 0],
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('hostname');

        $validator
            ->add('pid', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pid');

        $validator
            ->add('port', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('port');

        $validator
            ->add('gmt_created', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('gmt_created');

        $validator
            ->add('gmt_expires', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('gmt_expires');

        $validator
            ->add('count', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('count');

        $validator
            ->allowEmpty('activity');

        $validator
            ->allowEmpty('control');

        $validator
            ->allowEmpty('host_session_key');

        return $validator;
    }


    /**
     * Register engine in DB.(Was named Engine->get() in legacy versions of RPD)
     *
     *@param String $hostname Engine hostname.
     *@param Integer $pid PHP process id for engine.
     *@param String::uuid $sessionKey session key for engine.
     *@param Integer $port port of a socket.
     *@return bool
     */
    public function register(string $hostname, int $pid, string $sessionKey, int $port = 0)
    {
        $exist = $this->find()->where(['hostname' => $hostname, 'pid' =>$pid, 'host_session_key' => $sessionKey ])->first();
        if($exist === null) {
            $engine = $this->newEntity([
                    'hostname' => $hostname,
                    'pid' => $pid,
                    'port' => $port,
                    'host_session_key' => $sessionKey
                ]
            );
            if(!$this->save($engine)) {;
                return $engine->errors();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sets an activity type for Engine.
     *
     * @param String $activity engine activity.
     * @param Cake\ORM\Entity $entity instance of entity.
     * @return bool
     */
    public function setEngineActivity($activity, Engine $entity)
    {
        $activity == 'Idle' ?: $entity->set('count', ($entity->get('count') + 1));
        return ( $entity->set('activity',$activity) ) ? true : false;   
    }

    /**
     * Release this engine, its gone away.
     *
     * @param String $hostname engine host.
     * @param int $pid engine pid.
     * @return bool
     */
    public function kill(string $hostname, int $pid = 0) 
    {
        if(($data = $this->find()->where(['hostname' => $hostname, 'pid' => $pid])->first())) {
            $entity = $this->get($data->id);
            if(!$this->delete($entity)) {
                return $entity->errors();
            }
        }
        return true;
    }

     /**
     * Clean up all tasks related with engine id
     *
     * @param int $engineId engine id.
     * @param int $id activity id.
     * @return bool
     */
    public function pulseCheckClean(int $engineId, int $time = 300)
    {
        try { 
            $engine = $this->get($engineId);
            $tasks = $this->Tasks->find('all')->where(['id' => $engine->activity])->toArray();
            if(!empty($tasks)) {
                foreach($tasks as $value) {
                    if(!in_array($value->flag, ['WAIT', 'REENTER', 'ACTIVE'])) { 
                        $this->patchEntity($engine, ['gmt_expires' => time() + $time, 'activity' => 'Idle']);
                        if(!$this->save($engine)) {
                            return $engine->errors();
                        }
                    }
                }
            }
            return true;
        } catch(\Exception $e) {
            return false;
        }
            
    }

    /**
    * Hook for clean up engines from tasks, processes and deliveries
    *
    * @param int $id engine id
    * @return bool | errors from Task, Process, Delivery entities 
    **/
    public function cleanup($id)
    {
        $items = $this->find()->where(['id' => $id])->contain(['Tasks', 'Processes', 'Deliveries'])->first();
        foreach(['Tasks', 'Processes', 'Deliveries'] as $obj) {
            if(method_exists("\DBModel\Model\Table\\".$obj."Table", 'engineClean')) {
                if(isset($items[strtolower($obj)]) && !empty($items[strtolower($obj)])) {
                    if(($result = $this->{$obj}->engineClean($items[strtolower($obj)])) !== true) {
                        return $result;
                    }
                }
            }
        }
        return true;
    }

    /**
     * Get a zone which current engine belongs to
     *
     * @param void
     * @return Cake\ORM\Entity $entity instance of engines zone.
     */
    public function getMyZone(int $engineId)
    {
        try { 
            $myZone = $this->get($engineId, ['contain' => ['EngineHosts.Zones']]);
        }
        catch(\Exception $e) {
            return false;
        }
        return $myZone->engine_host->zone;
    }

}
