<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Loch;
use DBModel\Model\Table\AppTable;
use Cake\Datasource\ConnectionManager;

/**
 * Loches Model
 *
 */
class LochesTable extends AppTable
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

        $this->table('loches');
        $this->displayField('name');
        $this->primaryKey('id');
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
            ->allowEmpty('owner');

        $validator
            ->allowEmpty('name')
             ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('gmt_expires')
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
        $rules->add($rules->isUnique(['name']));
        return $rules;
    }

    /**
     * Obtain a lock. The lock will be valid across any console using this database.
     * @param string $name the name of the lock. an arbitrary string that is well known
     * @param string $owner a unique ID that identifies the user/process requesting the lock (maintain ID in order to free locks later)
     * @param int $lifespan seconds the lock should live, null for the default.
     * @param int tries number of attempts to get the lock
     * @param int $timeout  seconds to wait between tries
     * @return bool true|false
    **/
    public function getLock(string $name, string $owner, int $lifespan = 300, int $tries = 102, int $timeout = 3) 
    {
        if($tries == 0)
            $timeout = 0;
        while ($tries >= 0) {
            // self-cleanup. purge out any expired locks
            $this->deleteAll(['gmt_expires <=' => time()]);
            // see if the lock exists already
            $data = $this
                        ->findByName($name)
                        ->first();         
            if ($data) {
                if ($data->owner == $owner) {     // it does and we own it. give it a health pack
                    $data->gmt_expires = time() + $lifespan;

                    if(!$this->save($data)) {
                        return $data->errors();
                    }
                    return(true);
                } else {
                    sleep($timeout);    // it does but it's not ours
                }
            } else {
                // it doesn't exist. create it!
                $lock = $this->newEntity([
                    'owner' => $owner,
                    'name' => $name,
                    'gmt_expires' => time() + $lifespan,
                ]);
                try{
                    $res = $this->save($lock);
                    if(!$res) {
                        return $lock->errors();
                    }
                    return(true);
                } catch(\Exception $e) {
                    return false;
                }
                
            }
            $tries--;
        }
        // we never could get the lock for some reason
        return false;
    }
    
    /**
     * Release a lock, if you're the owner
     * @param string $name the name of the lock
     * @param string $owner a unique ID that identifies the user/process requesting the lock (maintain ID in order to free locks later)
     * @return bool true|false
    **/
    public function put(string $name, string $owner = '') 
    {   
        $this->identifyUpdate();
        $lockData = ['name' => $name];
        if ($owner){
            $lockData += ['owner' => $owner];
        }
        if (($data = $this->find()->where($lockData)->first()) !== null) {
            if(!$this->deleteAll($lockData)) {
                return $entity->errors();
            }
            return true;
        }
        return false;
    }

    /**
    * Updates identity value.
    * @return void
    */
    public function identifyUpdate ()
    {   
        $db = ConnectionManager::get('default');
        $config = $db->config();
        if ($config['driver'] === 'Cake\Database\Driver\Sqlserver') {
            $currentdentity = $db->execute("SELECT IDENT_CURRENT ('" . $this->table() . "') AS CurrentIdentity")->fetch('assoc');
            if ($currentdentity['currentidentity'] > (PHP_INT_MAX - 10000)) {
                $db->execute("DBCC CHECkIDENT ('" . $this->table() . "', RESEED, 1)");
            }
        }
        if ($config['driver'] === 'Cake\Database\Driver\Postgres') {
            $currentdentity = $db->execute("SELECT nextval('loches_id_seq') AS CurrentIdentity")->fetch('assoc');
            if ($currentdentity['currentidentity'] > (PHP_INT_MAX - 10000)) {
                $db->execute("ALTER SEQUENCE loches_id_seq RESTART WITH 1");
            }
        }
    }

}
